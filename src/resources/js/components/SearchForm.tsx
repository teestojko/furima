import React, { useState, useEffect, ChangeEvent } from 'react';
import '../styles/SearchForm.css';

// カテゴリの型定義
interface Category {
    id: number;
    name: string;
}

const SearchForm: React.FC = () => {
    // Stateの型指定
    const [categories, setCategories] = useState<Category[]>([]);
    const [filterUrl, setFilterUrl] = useState<string>('');
    const [isFormVisible, setIsFormVisible] = useState<boolean>(false);
    const [category, setCategory] = useState<string>('');
    const [productName, setProductName] = useState<string>('');
    const [minPrice, setMinPrice] = useState<string>('');
    const [maxPrice, setMaxPrice] = useState<string>('');
    const [priceOrder, setPriceOrder] = useState<string>('');
    const [popularity, setPopularity] = useState<string>('');

    useEffect(() => {
        // DOM内のカテゴリ情報が埋め込まれた要素を取得
        const categoriesElement = document.getElementById('categories');
        // フィルターURLが埋め込まれた要素を取得
        const filterUrlElement = document.getElementById('filter-url');

        // 要素が存在する場合、それぞれのデータ属性を取得し、stateを更新
        if (categoriesElement && filterUrlElement) {
            setCategories(JSON.parse(categoriesElement.dataset.categories || '[]'));
            setFilterUrl(filterUrlElement.dataset.url || '');
        }
    }, []);

    const toggleSearchForm = () => {
        setIsFormVisible(!isFormVisible);
    };

    const closeSearchForm = () => {
        setIsFormVisible(false);
    };

    const handleCategoryChange = (e: ChangeEvent<HTMLSelectElement>) => {
        setCategory(e.target.value);
    };

    const handleProductNameChange = (e: ChangeEvent<HTMLInputElement>) => {
        setProductName(e.target.value);
    };

    const handleMinPriceChange = (e: ChangeEvent<HTMLInputElement>) => {
        setMinPrice(e.target.value);
    };

    const handleMaxPriceChange = (e: ChangeEvent<HTMLInputElement>) => {
        setMaxPrice(e.target.value);
    };

    const handlePriceOrderChange = (e: ChangeEvent<HTMLSelectElement>) => {
        setPriceOrder(e.target.value);
    };

    const handlePopularityChange = (e: ChangeEvent<HTMLSelectElement>) => {
        setPopularity(e.target.value);
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
                                    onChange={handleCategoryChange}
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
                                    onChange={handleProductNameChange}
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
                                    onChange={handleMinPriceChange}
                                />
                                <input
                                    type="number"
                                    value={maxPrice}
                                    name="max_price"
                                    id="max_price"
                                    placeholder="Max"
                                    onChange={handleMaxPriceChange}
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
                                    onChange={handlePriceOrderChange}
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
                                    onChange={handlePopularityChange}
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
