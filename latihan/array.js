const bookList = [
{ id: 1, judul: 'Belajar JavaScript',
penulis: 'Rina', tahun: 2024 },
{ id: 2, judul: 'Dasar Pemrograman Web',
penulis: 'Budi', tahun: 2023 },
{ id: 3, judul: 'Mengenal Node.js',
penulis: 'Sari', tahun: 2025 },
{ id: 4, judul: 'Menguasai React',
penulis: 'Hafidz', tahun: 2026 }
];
console.log(bookList[0].judul);
console.log(bookList[2].penulis);
console.log('Jumlah buku:', bookList.length);
bookList.forEach((book, index) => {
console.log(`${index + 1}. ${book.judul}`);
});