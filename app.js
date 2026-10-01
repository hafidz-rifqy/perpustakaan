const express = require('express');
const path = require('path');
const bookRoutes = require('./routes/bookRoutes');
const app = express();
const PORT = 3000;
app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, 'views'));
app.get('/', (req, res) => {
res.redirect('/books');
});
app.use('/books', bookRoutes);
app.listen(PORT, () => {
console.log(`Buka http://localhost:${PORT}/books`);
});