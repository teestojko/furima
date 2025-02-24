import React, { useState } from "react";

type FavoriteButtonProps = {
    productId: number;
    isFavorite: boolean;
};

const FavoriteButton: React.FC<FavoriteButtonProps> = ({ productId, isFavorite }) => {
    const [favorite, setFavorite] = useState<boolean>(isFavorite);

    console.log("FavoriteButton - productId:", productId, "isFavorite:", isFavorite);

    const toggleFavorite = async () => {
        try {
            const response = await fetch(`/favorites/${productId}/toggle`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": (document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement)?.content || ""
                },
                body: JSON.stringify({})
            });

            if (!response.ok) {
                throw new Error("サーバーエラー");
            }

            const data = await response.json();
            setFavorite(data.status === "added");
        } catch (error) {
            console.error("通信エラー:", error);
            alert("通信エラーが発生しました");
        }
    };

    return (
        <button onClick={toggleFavorite} className="favorite-btn" style={{ fontSize: "24px", padding: "10px" }}>
            {favorite ? "💖 お気に入り解除" : "❤️ お気に入り"}
        </button>
    );
};

export default FavoriteButton;
