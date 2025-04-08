import { readFile } from 'fs/promises';
import path from 'path';
import { parse } from 'csv-parse/sync';

export default async function handler(req, res) {
  if (req.method !== 'POST') {
    return res.status(405).json({ message: 'Only POST requests allowed' });
  }

  const { message } = req.body;

  if (!message) {
    return res.status(400).json({ message: 'No message provided' });
  }

  try {
    const filePath = path.join(process.cwd(), 'katalog.tsv');
    const fileContent = await readFile(filePath, 'utf-8');

    const records = parse(fileContent, {
      columns: true,
      delimiter: '\t'
    });

    const input = message.toLowerCase();

    const found = records.find(item => item.nama?.toLowerCase().includes(input));

    if (found) {
      const response = `📦 ${found.nama}\n💵 Harga jual: Rp ${Number(found.harga).toLocaleString('id-ID')}/pcs`;
      return res.status(200).json({ reply: response });
    } else {
      return res.status(404).json({ reply: 'Produk tidak ditemukan di katalog.' });
    }
  } catch (error) {
    console.error(error);
    return res.status(500).json({ message: 'Server error' });
  }
}
