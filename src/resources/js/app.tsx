import React, { useEffect } from 'react';
import ReactDOM from 'react-dom/client'; // React 18 では `react-dom/client` を使う
import SearchForm from './components/searchForm';
import Sidebar from './components/sidebar';
import { randomizeLights } from './components/lightEffect';
import FileDisplay from './components/FileDisplay';

const App: React.FC = () => {
    useEffect(() => {
        // 光のエフェクトを初期化
        randomizeLights();
    }, []);

    useEffect(() => {
        // id="file-display" を探して、存在する場合のみ FileDisplay をレンダリング
        const fileDisplayElement = document.getElementById('file-display');
        if (fileDisplayElement) {
            const root = ReactDOM.createRoot(fileDisplayElement);
            root.render(<FileDisplay />);
        }
    }, []);

    useEffect(() => {
        // id="search-form" がある場合のみ SearchForm をレンダリング
        const searchFormElement = document.getElementById('search-form');
        if (searchFormElement) {
            const root = ReactDOM.createRoot(searchFormElement);
            root.render(<SearchForm />);
        }
    }, []);

    return (
        <div>
            <Sidebar />
        </div>
    );
};

// React 18 のレンダリング方法
const container = document.getElementById('app');
if (container) {
    const root = ReactDOM.createRoot(container);
    root.render(<App />);
}

