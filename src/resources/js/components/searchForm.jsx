import React, { useState } from 'react';
import './styles/searchForm.css';

const SearchForm = ({ categories, filterUrl }) => {
    const [isFormVisible, setIsFormVisible] = useState(false);
    const [category, setCategory] = useState('');
    const [productName, setProductName] = useState('');
    const [minPrice, setMinPrice] = useState('');
    const [maxPrice, setMaxPrice] = useState('');
    const [priceOrder, setPriceOrder] = useState('');
    const [popularity, setPopularity] = useState('');

    const toggleSearchForm = () => {
        setIsFormVisible(!isFormVisible);
    };

    const closeSearchForm = () => {
        setIsFormVisible(false);
    };

    return (
        <div className="index_form">
            <div className="index_search">
                <nav>
                    <button id="toggle-search-btn" onClick={toggleSearchForm}>
                        検索
                    </button>
                </nav>
            </div>

            {/* 検索フォーム */}
            {isFormVisible && (
                <>
                    <form action={filterUrl} method="GET" className="search_form">
                        <div className="search_container">
                            {/* カテゴリ選択 */}
                            <div className="index_search_category">
                                <label className="index_search_label" htmlFor="category_id">
                                    カテゴリ
                                </label>
                                <select
                                    className="index_search_select_category"
                                    value={category}
                                    name="category_id"
                                    id="category_id"
                                    onChange={(e) => setCategory(e.target.value)}
                                >
                                    <option value="">All category</option>
                                    {categories.map((cat) => (
                                        <option key={cat.id} value={cat.id}>
                                            {cat.name}
                                        </option>
                                    ))}
                                </select>
                            </div>

                            {/* 商品名検索 */}
                            <div className="index_search_product_name">
                                <label className="index_search_label" htmlFor="product_name">
                                    商品名
                                </label>
                                <input
                                    type="text"
                                    value={productName}
                                    name="product_name"
                                    id="product_name"
                                    className="search_input"
                                    placeholder="Search ..."
                                    onChange={(e) => setProductName(e.target.value)}
                                />
                            </div>

                            {/* 価格帯の絞り込み */}
                            <div className="index_search_price_range">
                                <label className="index_search_label" htmlFor="min_price">
                                    価格帯
                                </label>
                                <input
                                    type="number"
                                    value={minPrice}
                                    name="min_price"
                                    id="min_price"
                                    placeholder="Min"
                                    onChange={(e) => setMinPrice(e.target.value)}
                                />
                                <input
                                    type="number"
                                    value={maxPrice}
                                    name="max_price"
                                    id="max_price"
                                    placeholder="Max"
                                    onChange={(e) => setMaxPrice(e.target.value)}
                                />
                            </div>

                            {/* 価格順の並び替え */}
                            <div className="index_search_price_order">
                                <label className="index_search_label" htmlFor="price_order">
                                    価格順
                                </label>
                                <select
                                    value={priceOrder}
                                    name="price_order"
                                    id="price_order"
                                    onChange={(e) => setPriceOrder(e.target.value)}
                                >
                                    <option value="">Select</option>
                                    <option value="asc">安い順</option>
                                    <option value="desc">高い順</option>
                                </select>
                            </div>

                            {/* 人気順の並び替え */}
                            <div className="index_search_popularity">
                                <label className="index_search_label" htmlFor="popularity">
                                    人気順
                                </label>
                                <select
                                    value={popularity}
                                    name="popularity"
                                    id="popularity"
                                    onChange={(e) => setPopularity(e.target.value)}
                                >
                                    <option value="">Select</option>
                                    <option value="desc">人気順</option>
                                </select>
                            </div>
                        </div>

                        {/* 検索ボタン */}
                        <div className="search_button">
                            <button className="search_button_link" type="submit">
                                検索
                            </button>
                        </div>
                    </form>

                    {/* オーバーレイ */}
                    <div
                        id="overlay"
                        className="overlay"
                        onClick={closeSearchForm}
                    ></div>
                </>
            )}
        </div>
    );
};

export default SearchForm;
