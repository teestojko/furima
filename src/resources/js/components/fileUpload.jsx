import React, { useState } from 'react';

const FileUpload = () => {
    // ファイル名を管理するstate
    const [fileName, setFileName] = useState('選択ファイル名');

    // ファイル選択時のイベントハンドラ
    const handleFileChange = (event) => {
        if (event.target.files.length > 0) {
            setFileName(event.target.files[0].name); // 最初に選択したファイル名をstateに保存
        } else {
            setFileName('選択ファイル名'); // ファイルが未選択の場合のデフォルト表示
        }
    };

    return (
        <div className="file-upload">
            <div className="content_title">画像</div>
            {/* ファイル選択ラベル */}
            <label className="images_label" htmlFor="images">
                画像を選択
            </label>
            {/* ファイル選択のinput */}
            <input
                type="file"
                name="images"
                id="images"
                multiple
                onChange={handleFileChange} // イベントハンドラを設定
            />
            {/* 選択されたファイル名を表示 */}
            <div id="file_name">{fileName}</div>
        </div>
    );
};

export default FileUpload;


