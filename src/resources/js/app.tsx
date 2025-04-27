import React, { useEffect } from 'react';
import ReactDOM from 'react-dom/client';
import SearchForm from './components/SearchForm';
import Sidebar from './components/Sidebar';
import { randomizeLights } from './components/LightEffect';
import FileDisplay from './components/FileDisplay';
import FavoriteButton from "./components/FavoriteButton";

const App: React.FC = () => {
    useEffect(() => {
        randomizeLights();
    }, []);

    useEffect(() => {
        const fileDisplayElement = document.getElementById('file-display');
        if (fileDisplayElement) {
            const root = ReactDOM.createRoot(fileDisplayElement);
            root.render(<FileDisplay />);
        }
    }, []);

    useEffect(() => {
        const searchFormElement = document.getElementById('search-form');
        if (searchFormElement) {
            const root = ReactDOM.createRoot(searchFormElement);
            root.render(<SearchForm />);
        }
    }, []);


    useEffect(() => {
        const favoriteButtons = document.querySelectorAll(".favorite-button");

        favoriteButtons.forEach((button) => {
            const productId = Number(button.getAttribute("data-product-id"));
            const isFavorite = button.getAttribute("data-is-favorite") === "true";

            const root = ReactDOM.createRoot(button);
            root.render(<FavoriteButton productId={productId} isFavorite={isFavorite} />);
        });

    }, []);

    const isLoggedIn = (window as any).Laravel?.isLoggedIn;
    return (
        <div>
            {isLoggedIn && <Sidebar />}
        </div>
    );
};

const container = document.getElementById('app');
if (container) {
    const root = ReactDOM.createRoot(container);
    root.render(<App />);
}

