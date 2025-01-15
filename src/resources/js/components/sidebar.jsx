import React, { useState } from "react";
import "../styles/sidebar.css"; // CSSファイル

const Sidebar = () => {
    const [isHovered, setIsHovered] = useState(false);
    const userId = 1; // 適切なユーザーIDを設定

    return (
        <div
        className="sidebar-container"
        onMouseEnter={() => setIsHovered(true)}
        onMouseLeave={() => setIsHovered(false)}
        >
        <div className={`sidebar ${isHovered ? "visible" : "hidden"}`}>
            <div className="index_nav">
            <div className="index_products_create">
                <a
                className={`products_create_link ${isHovered ? "hovered" : ""}`}
                href="/products/create"
                >
                出品
                </a>
            </div>
            <div className="index_profile">
                <a
                className={`profile_link ${isHovered ? "hovered" : ""}`}
                href={`/profile/${userId}`}
                >
                プロフィール
                </a>
            </div>
            <div className="index_cart">
                <a
                className={`cart_link ${isHovered ? "hovered" : ""}`}
                href="/cart"
                >
                カート
                </a>
            </div>
            <div className="index_coupon">
                <a
                className={`coupon_link ${isHovered ? "hovered" : ""}`}
                href="/coupons"
                >
                クーポン一覧
                </a>
            </div>
            <div className="index_my_page">
                <a
                className={`my_page_link ${isHovered ? "hovered" : ""}`}
                href="/my_page"
                >
                マイページ
                </a>
            </div>
            </div>
        </div>
        <div className="arrow">&larr; {/* 左矢印 */}</div>
        </div>
    );
};

export default Sidebar;
