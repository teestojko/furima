import React, { useState } from 'react';
import '../styles/sidebar.css'; // CSSファイルのパス

const Sidebar = () => {
    const [isHovered, setIsHovered] = useState(false);

    return (
        <div
        className="sidebar-container"
        onMouseEnter={() => setIsHovered(true)}
        onMouseLeave={() => setIsHovered(false)}
        >
        <div className={`sidebar ${isHovered ? 'visible' : 'hidden'}`}>
            <ul>
            <li>Home</li>
            <li>About</li>
            <li>Contact</li>
            </ul>
        </div>
        <div className="arrow">
            &larr; {/* 左矢印 */}
        </div>
        </div>
    );
};

export default Sidebar;
