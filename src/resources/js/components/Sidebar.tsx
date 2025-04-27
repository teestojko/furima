import React, { useState } from "react";
import "../styles/Sidebar.css";
import "@fortawesome/fontawesome-free/css/all.css";
import axios from "axios";

const Sidebar: React.FC = () => {
    const [isHovered, setIsHovered] = useState<boolean>(false);

    const userId: number = 1;

    const handleLogout = async () => {
        try {
            await axios.post("/logout", {}, {
                headers: {
                    "X-CSRF-TOKEN": (document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement)?.content || ""
                },
                withCredentials: true
            });
            window.location.href = "/login";
        } catch (error) {
            console.error("ログアウトに失敗しました。", error);
        }
    };

    return (
        <div
            className="sidebar-container"
            onMouseEnter={() => setIsHovered(true)}
            onMouseLeave={() => setIsHovered(false)}
        >
            <div className={`sidebar ${isHovered ? "visible" : "hidden"}`}>
                <div className="index_nav">
                    <a
                        className={`index_link ${isHovered ? "hovered" : ""}`}
                        href="/"
                    >
                        <i className="fas fa-home"></i>
                            ホーム
                    </a>
                    <a
                        className={`products_create_link ${isHovered ? "hovered" : ""}`}
                        href="/products/create"
                    >
                        <i className="fas fa-plus"></i>
                            出品
                    </a>
                    <a
                        className={`profile_link ${isHovered ? "hovered" : ""}`}
                        href={`/profile`}
                    >
                        <i className="fas fa-user"></i>
                            プロフィール
                    </a>
                    <a
                        className={`cart_link ${isHovered ? "hovered" : ""}`}
                        href="/cart"
                    >
                        <i className="fas fa-shopping-cart"></i>
                            カート
                    </a>
                    <a
                        className={`coupon_link ${isHovered ? "hovered" : ""}`}
                        href="/coupons"
                    >
                        <i className="fas fa-tags"></i>
                            クーポン一覧
                    </a>
                    <a
                        className={`my_page_link ${isHovered ? "hovered" : ""}`}
                        href="/my_page"
                    >
                        <i className="fas fa-user"></i>
                            マイページ
                    </a>
                    <a
                        href="#"
                        className="nav_button"
                        onClick={(e) => {
                            e.preventDefault();
                            handleLogout();
                        }}
                    >
                    <i className="fas fa-right-from-bracket"></i>
                        Logout
                    </a>

                </div>
            </div>
            <div className="arrow">&larr;</div>
        </div>
    );
};

export default Sidebar;

