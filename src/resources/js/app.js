/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

// Laravelのプロジェクトで必要なJavaScriptの依存関係を読み込む（Reactやその他のヘルパー含む）。
require('./bootstrap');

/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Reactコンポーネントを読み込み、アプリケーションに追加する準備を行う。
require('./components/Example');

// ReactおよびReactのフック（useState, useEffect）をインポート
import React, { useEffect } from 'react';
// ReactDOMをインポートしてDOM操作を可能にする
import ReactDOM from 'react-dom';
import SearchForm from './components/searchForm';
import Sidebar from './components/sidebar';
import FileUpload from './components/fileUpload';
import { randomizeLights } from './components/lightEffect';
import FileDisplay from './components/fileDisplay';


// アプリケーションのメインコンポーネントを定義
const App = () => {

    document.addEventListener('DOMContentLoaded', () => {
        const fileUploadElement = document.getElementById('file-upload');
        if (fileUploadElement) {
            ReactDOM.render(<FileUpload />, fileUploadElement);
        } else {
            console.error('FileUpload element not found!');
        }
    });

    useEffect(() => {
    // 光のエフェクトを初期化
    randomizeLights();
    }, []);

    document.addEventListener('DOMContentLoaded', () => {
    const fileUploadElement = document.getElementById('file-display');
    if (fileUploadElement) {
        ReactDOM.render(<FileDisplay />, fileUploadElement);
    }
});

    // コンポーネントのレンダリング内容を返す
    return (
        <div>
            <Sidebar />
            <SearchForm />
        </div>
    );
};

// Appコンポーネントを#app要素内にレンダリング
ReactDOM.render(<App />, document.getElementById('app'));



