<template>
    <div class="index_nav">
        <div class="index_products_create">
            <a class="products_create_link" href="/products/create" @mouseover="hover = true" @mouseleave="hover = false" :class="{'hovered': hover}">
                出品
            </a>
        </div>
        <div class="index_profile">
            <a class="profile_link" :href="`/profile/${userId}`" @mouseover="hover = true" @mouseleave="hover = false" :class="{'hovered': hover}">
                プロフィール
            </a>
        </div>
        <div class="index_cart">
            <a class="cart_link" href="{{ route('cart-view') }}" @mouseover="hover = true" @mouseleave="hover = false" :class="{'hovered': hover}">
                カート
            </a>
        </div>
        <div class="index_coupon">
            <a class="coupon_link" href="{{ route('coupons-index') }}" @mouseover="hover = true" @mouseleave="hover = false" :class="{'hovered': hover}">
                クーポン一覧
            </a>
        </div>
        <div class="index_my_page">
            <a class="my_page_link" href="{{ route('user-my-page') }}" @mouseover="hover = true" @mouseleave="hover = false" :class="{'hovered': hover}">
                マイページ
            </a>
        </div>
    </div>
</template>

<script>
    export default {
    data() {
        return {
            hover: false,
            userId: 1, // ユーザーIDを動的に設定する場合
        };
    },
};
</script>
