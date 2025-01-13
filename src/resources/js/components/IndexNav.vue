<template>
    <div>
        <!-- 左矢印トリガー -->
        <div
            class="left_trigger"
            @mouseover="showNav = true"
            @mouseleave="showNav = false">
            ←
        </div>

        <!-- ナビゲーションメニュー -->
        <div
            class="index_nav"
            v-if="showNav"
            @mouseleave="showNav = false">
            <div class="index_products_create">
                <a class="products_create_link" href="/products/create"
                    @mouseover="hover = true"
                    @mouseleave="hover = false"
                    :class="{'hovered': hover}">
                    出品
                </a>
            </div>
            <div class="index_profile">
                <a class="profile_link" :href="`/profile/${userId}`"
                    @mouseover="hover = true"
                    @mouseleave="hover = false"
                    :class="{'hovered': hover}">
                    プロフィール
                </a>
            </div>
            <div class="index_cart">
                <a class="cart_link" href="/cart"
                    @mouseover="hover = true"
                    @mouseleave="hover = false"
                    :class="{'hovered': hover}">
                    カート
                </a>
            </div>
            <div class="index_coupon">
                <a class="coupon_link" href="/coupons"
                    @mouseover="hover = true"
                    @mouseleave="hover = false"
                    :class="{'hovered': hover}">
                    クーポン一覧
                </a>
            </div>
            <div class="index_my_page">
                <a class="my_page_link" href="/my_page"
                    @mouseover="hover = true"
                    @mouseleave="hover = false"
                    :class="{'hovered': hover}">
                    マイページ
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
    data() {
        return {
            hover: false,
            showNav: false, // ナビゲーションの表示/非表示を管理
            userId: 1, // ユーザーIDを動的に設定する場合
        };
    },
};
</script>

<style scoped>
/* トリガー部分のスタイル */
.left_trigger {
    position: fixed;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 30px;
    height: 30px;
    background: lightgray;
    text-align: center;
    line-height: 30px;
    border-radius: 50%;
    cursor: pointer;
    font-weight: bold;
}

/* ナビゲーションの初期状態を非表示 */
.index_nav {
    position: fixed;
    left: 30px;
    top: 50%;
    transform: translateY(-50%);
    background: white;
    border: 1px solid #ddd;
    padding: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: opacity 0.3s;
}
</style>
