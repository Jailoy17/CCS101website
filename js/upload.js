

document.getElementById('uploadButton').addEventListener('click', () => {
      const fileInput = document.getElementById('fileInput');
      const file = fileInput.files[0];
    
      if (!file) {
        alert('Please select a file!');
        return;
      }
    
      const addMoreButton = document.getElementById("addMore");
      const preview = document.getElementById('preview');
      const reader = new FileReader();
      reader.onload = () => {
        preview.innerHTML = `<img src="${reader.result}" alt="Preview" style="max-width: 200px; max-height: 200px;" />`;
      };
      reader.readAsDataURL(file);
    
      const formData = new FormData();

  formData.append('photo', file);

  fetch('/upload', {
    method: 'POST',
    body: formData,
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error('Upload failed!');
      }
      return response.json();
    })
    .then((data) => {
      alert(`File uploaded successfully: ${data.fileUrl}`);
    })
    .catch((error) => {
      console.error(error);
      alert('An error occurred while uploading the file.');
    });
});