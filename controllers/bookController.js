exports.index = (req, res) => {
const bookList = [
{
    id: 1,
    judul: 'Belajar JavaScript',
    penulis: 'Rina',
    tahun: 2024
},
{
    id: 2,
    judul: 'Dasar Pemrograman Web',
    penulis: 'Budi',
    tahun: 2023
},
{
    id: 3,
    judul: 'Mengenal Node.js',
    penulis: 'Sari',
    tahun: 2025
},
{
    id: 4,
    judul: 'Logika Pemrograman',
    penulis: 'Dewi',
    tahun: 2026
}
];
    res.render('books/index', {
    pageTitle: 'Daftar Buku Perpustakaan',
    bookList: bookList
});
};