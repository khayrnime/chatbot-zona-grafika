import { google } from 'googleapis';

export default async function handler(req, res) {
  const { message = '' } = req.query;

  // Setup Google Auth
  const auth = new google.auth.GoogleAuth({
    credentials: {
      client_email: process.env.GOOGLE_CLIENT_EMAIL,
      private_key: process.env.GOOGLE_PRIVATE_KEY.replace(/\\n/g, '\n'),
    },
    scopes: ['https://www.googleapis.com/auth/spreadsheets.readonly'],
  });

  const sheets = google.sheets({ version: 'v4', auth });

  const spreadsheetId = '1di5k8D6uOEJ_IPIXptbs_Bg7ybkV1LtTgj180_LY7jM';

  try {
    // Baca sheet pertama misal (nanti bisa kamu atur sheet mana sesuai pesan)
    const range = 'Sheet1!A2:B100'; // Misal data ada di kolom A dan B
    const response = await sheets.spreadsheets.values.get({
      spreadsheetId,
      range,
    });

    const rows = response.data.values;

    let reply = "Maaf, saya tidak menemukan jawaban.";

    if (rows && rows.length) {
      for (const row of rows) {
        if (row[0] && message.toLowerCase().includes(row[0].toLowerCase())) {
          reply = row[1] || "Data ditemukan, tapi kosong.";
          break;
        }
      }
    }

    res.status(200).json({ reply });
  } catch (error) {
    console.error('Error:', error);
    res.status(500).json({ reply: "Terjadi kesalahan di server." });
  }
}
