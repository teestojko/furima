<template>
    <div class="index_form">
        <div class="index_search">
            <nav>
                <button id="toggle-search-btn" @click.prevent="toggleSearchForm">検索</button>
            </nav>
        </div>

        <!-- 検索フォーム -->
        <form :action="filterUrl" method="GET" v-show="isFormVisible" class="search_form">
            <div class="search_container">
                <!-- カテゴリ選択 -->
                <div class="index_search_category">
                    <label class="index_search_label" for="category_id">カテゴリ</label>
                    <select class="index_search_select_category" v-model="category" name="category_id" id="category_id">
                        <option value="">All category</option>
                        <option v-for="category in categories" :key="category.id" :value="category.id">
                            {{ category.name }}
                        </option>
                    </select>
                </div>

                <!-- 商品名検索 -->
                <div class="index_search_product_name">
                    <label class="index_search_label" for="product_name">商品名</label>
                    <input type="text" v-model="productName" name="product_name" id="product_name" class="search_input" placeholder="Search ..." />
                </div>

                <!-- 価格帯の絞り込み -->
                <div class="index_search_price_range">
                    <label class="index_search_label" for="min_price">価格帯</label>
                    <input type="number" v-model="minPrice" name="min_price" id="min_price" placeholder="Min" />
                    <input type="number" v-model="maxPrice" name="max_price" id="max_price" placeholder="Max" />
                </div>

                <!-- 価格順の並び替え -->
                <div class="index_search_price_order">
                    <label class="index_search_label" for="price_order">価格順</label>
                    <select v-model="priceOrder" name="price_order" id="price_order">
                        <option value="">Select</option>
                        <option value="asc">安い順</option>
                        <option value="desc">高い順</option>
                    </select>
                </div>

                <!-- 人気順の並び替え -->
                <div class="index_search_popularity">
                    <label class="index_search_label" for="popularity">人気順</label>
                    <select v-model="popularity" name="popularity" id="popularity">
                        <option value="">Select</option>
                        <option value="desc">人気順</option>
                    </select>
                </div>
            </div>

            <!-- 検索ボタン -->
            <div class="search_button">
                <button class="search_button_link" type="submit">検索</button>
            </div>
        </form>
        <!-- オーバーレイ -->
        <div v-show="isFormVisible" id="overlay" class="overlay" @click="closeSearchForm"></div>
    </div>
</template>

<script>
export default {
    props: {
        categories: Array,  // Bladeから受け取ったカテゴリデータ
        filterUrl: String   // 親から受け取った検索フォームのURL
    },
    data() {
        return {
            isFormVisible: false,
            category: '',
            productName: '',
            minPrice: '',
            maxPrice: '',
            priceOrder: '',
            popularity: ''
        };
    },
    methods: {
        toggleSearchForm() {
            // フォームとオーバーレイの表示状態を切り替え
            this.isFormVisible = !this.isFormVisible;
        },
        closeSearchForm() {
            // オーバーレイをクリックしたときにフォームとオーバーレイを非表示にする
            this.isFormVisible = false;
        }
    }
};
</script>


