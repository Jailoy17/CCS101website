const express = require('express');
const multer = require('multer');
const path = require('path');

const app = express();
const upload = multer({ dest: 'uploads/' });

app.post('/upload', upload.single('photo'), (req, res) => {
  if (!req.file) {
    return res.status(400).send('No file uploaded.');
  }

  const fileUrl = path.join('uploads', req.file.filename);
  res.json({ fileUrl });
});

Array.from(files).forEach((file) => {
    if (file.type.startsWith("image/")) {
        const reader = new FileReader();

        reader.onload = (e) => {
           
            const img = document.createElement("img");
            img.src = e.target.result;
            img.alt = file.name;

            imageContainer.appendChild(img);
        };

        reader.readAsDataURL(file);
    } else {
        alert(`${file.name} is not a valid image file.`);
    }
});

app.listen(3000, () => {
  console.log('Server running on http://localhost:3000');
});