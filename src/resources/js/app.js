/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

// Laravelのプロジェクトで必要なJavaScriptの依存関係を読み込む（Reactやその他のヘルパー含む）。
require('./bootstrap');

/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Reactコンポーネントを読み込み、アプリケーションに追加する準備を行う。
require('./components/Example');

// ReactおよびReactのフック（useState, useEffect）をインポート
import React, { useState, useEffect } from 'react';
// ReactDOMをインポートしてDOM操作を可能にする
import ReactDOM from 'react-dom';
// カスタムコンポーネント（SearchFormとSidebar）をインポート
import SearchForm from './components/searchForm';
import Sidebar from './components/sidebar';

document.addEventListener('DOMContentLoaded', () => {
    const sidebarElement = document.getElementById('sidebar');
    if (sidebarElement) {
        ReactDOM.render(<Sidebar />, sidebarElement);
    } else {
        console.error('Sidebar element not found!');
    }
});

// アプリケーションのメインコンポーネントを定義
const App = () => {
    // カテゴリデータを管理するためのstate
    const [categories, setCategories] = useState([]);
    // フィルター用URLを管理するためのstate
    const [filterUrl, setFilterUrl] = useState('');

    // コンポーネントが初めて描画されたときに実行される副作用処理
    useEffect(() => {
        // DOM内のカテゴリ情報が埋め込まれた要素を取得
        const categoriesElement = document.getElementById('categories');
        // フィルターURLが埋め込まれた要素を取得
        const filterUrlElement = document.getElementById('filter-url');

        // 要素が存在する場合、それぞれのデータ属性を取得し、stateを更新
        if (categoriesElement && filterUrlElement) {
            setCategories(JSON.parse(categoriesElement.dataset.categories)); // JSON文字列を配列に変換して設定
            setFilterUrl(filterUrlElement.dataset.url); // URLを文字列として設定
        }
    }, []); // 空の依存配列を指定することで、初回の1回だけ実行される

    // コンポーネントのレンダリング内容を返す
    return (
        <div>
            <Sidebar />
            {/* SearchFormコンポーネントをレンダリングし、propsとしてcategoriesとfilterUrlを渡す */}
            <SearchForm categories={categories} filterUrl={filterUrl} />
        </div>
    );
};

// Appコンポーネントを#app要素内にレンダリング
ReactDOM.render(<App />, document.getElementById('app'));



