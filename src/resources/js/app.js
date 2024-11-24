require('./bootstrap');

import { createApp } from 'vue';  // Vue 3 のインポート
import IndexNav from './components/IndexNav.vue';  // 作成したコンポーネントのインポート
import IndexForm from './components/IndexForm.vue';    // 検索フォームコンポーネント

// Vue アプリケーションを作成
const app = createApp({});

// コンポーネントをグローバルに登録
app.component('index_nav', IndexNav);
app.component('index_form', IndexForm);

// Vue アプリケーションをマウント
app.mount('#app');
