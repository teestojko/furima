import React, { useEffect } from 'react';
import ReactDOM from 'react-dom/client'; // React 18 では `react-dom/client` を使う
import SearchForm from './components/SearchForm';
import Sidebar from './components/Sidebar';
import { randomizeLights } from './components/LightEffect';
import FileDisplay from './components/FileDisplay';
import FavoriteButton from "./components/FavoriteButton";

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


    // useEffect(() => {
    //     const favoriteButtons = document.querySelectorAll(".favorite-button");

    //     console.log("お気に入りボタン要素:", document.querySelectorAll(".favorite-button"));


    //     favoriteButtons.forEach((button) => {
    //         const productId = Number(button.getAttribute("data-product-id"));
    //         const isFavorite = button.getAttribute("data-is-favorite") === "true";

    //         // console.log("Rendering FavoriteButton for productId:", productId, "isFavorite:", isFavorite);

    //         const root = ReactDOM.createRoot(button);
    //         root.render(<FavoriteButton productId={productId} isFavorite={isFavorite} />);
    //     });
    // }, []);

    useEffect(() => {
        setTimeout(() => {
            const favoriteButtons = document.querySelectorAll(".favorite-button");

            favoriteButtons.forEach((button) => {
                const productId = Number(button.getAttribute("data-product-id"));
                const isFavorite = button.getAttribute("data-is-favorite") === "true";

                console.log("Rendering FavoriteButton for productId:", productId, "isFavorite:", isFavorite);

                const root = ReactDOM.createRoot(button);
                root.render(<FavoriteButton productId={productId} isFavorite={isFavorite} />);
            });
        }, 500); // 0.5秒遅延
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

