import React, { useState } from 'react';

const FileDisplay = () => {
    const [previews, setPreviews] = useState([]);

    const handleFileChange = (event) => {
        const files = Array.from(event.target.files);

        const filePreviews = files.map((file) => {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.onload = () => resolve({ src: reader.result, name: file.name });
                reader.onerror = (error) => reject(error);
                reader.readAsDataURL(file);
            });
        });

        Promise.all(filePreviews)
            .then((results) => setPreviews(results))
            .catch((error) => console.error('Error reading files:', error));
    };

    return (
        <div>
            <input
                type="file"
                id="images"
                name="images[]"
                multiple
                className="form-file-input"
                onChange={handleFileChange}
            />
            <div id="preview-container">
                {previews.map((preview, index) => (
                    <img
                        key={index}
                        src={preview.src}
                        alt={preview.name}
                        className="preview-image"
                    />
                ))}
            </div>
        </div>
    );
};

export default FileDisplay;
