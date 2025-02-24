import { useState } from "react";

interface FavoriteButtonProps {
    productId: number;
    isFavorite: boolean;
}

const FavoriteButton: React.FC<FavoriteButtonProps> = ({ productId, isFavorite }) => {
    const [favorite, setFavorite] = useState<boolean>(isFavorite);

    const toggleFavorite = async () => {
        try {
            const response = await fetch(`/favorites/${productId}/toggle`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": (document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement)?.content ?? "",
                },
            });

            if (!response.ok) {
                throw new Error("サーバーエラー");
            }

            const result = await response.json();
            setFavorite(result.status === "added");
        } catch (error) {
            console.error("通信エラーが発生しました", error);
        }
    };

    return (
        <button onClick={toggleFavorite} className="favorite-btn">
            {favorite ? "💖 お気に入り解除" : "❤️ お気に入り"}
        </button>
    );
};

export default FavoriteButton;
