import React, { useState, ChangeEvent } from 'react';
import "../styles/fileDisplay.css";

// プレビュー用のファイル情報の型定義
interface FilePreview {
    src: string | ArrayBuffer | null;
    name: string;
}

const FileDisplay: React.FC = () => {
    // previewsの型をFilePreviewの配列に指定
    const [previews, setPreviews] = useState<FilePreview[]>([]);

    // handleFileChangeのイベント引数に型を指定
    const handleFileChange = (event: ChangeEvent<HTMLInputElement>) => {
        const files = Array.from(event.target.files || []);

        const filePreviews = files.map((file) => {
            return new Promise<FilePreview>((resolve, reject) => {
                const reader = new FileReader();
                reader.onload = () => resolve({ src: reader.result, name: file.name });
                reader.onerror = (error) => reject(error);
                reader.readAsDataURL(file);
            });
        });

        // Promise.allの結果がFilePreview型であることを指定
    Promise.all(filePreviews)
        .then((results) => setPreviews(results))
        .catch((error) => console.error('Error reading files:', error));
    };

    const removeImage = (index: number) => {
        setPreviews(previews.filter((_, i) => i !== index));
    };

    return (
        <div className="file-upload-container">
            <label htmlFor="images" className="custom-file-upload">
                画像を選択
            </label>
            <input
                type="file"
                id="images"
                name="images[]"
                multiple
                className="file-input-hidden"
                onChange={handleFileChange}
            />

            <div className="preview-container">
                {previews.map((preview, index) => (
                    <div key={index} className="preview-item">
                        <img src={preview.src as string} alt={preview.name} className="preview-image" />
                        <button className="remove-button" onClick={() => removeImage(index)}>×</button>
                    </div>
                ))}
            </div>
        </div>
    );
};



export default FileDisplay;
