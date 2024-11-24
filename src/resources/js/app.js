require('./bootstrap');

import { createApp } from 'vue';  // Vue 3 のインポート
import ButtonHover from './components/ButtonHover.vue';  // 作成したコンポーネントのインポート

// Vue アプリケーションを作成
const app = createApp({});

// コンポーネントをグローバルに登録
app.component('button_hover', ButtonHover);

// Vue アプリケーションをマウント
app.mount('#app');
