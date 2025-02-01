export function randomizeLights() {
    // `.light-effect` クラスを持つ全ての要素を取得
    const lightEffects = document.querySelectorAll<HTMLElement>('.light-effect');

    // `.index_inner` クラスを持つ要素を取得
    const container = document.querySelector<HTMLElement>('.index_inner');

    // containerが存在する場合のみ処理を開始
    if (!container) {
        console.error('Container not found');
        return;
    }

    function updateLights() {
        // コンテナの高さを取得
        const containerHeight = container!.offsetHeight;

        lightEffects.forEach(light => {
            // ランダムな値を生成
            const randomX = Math.random() * 100;
            const randomY = Math.random() * containerHeight;
            const randomScale = Math.random() * 1 + 1;
            const randomOpacity = Math.random() * 0.4 + 0.3;
            const randomHue = Math.floor(Math.random() * 360);
            const randomSaturation = Math.random() * 50 + 50;
            const randomLightness = Math.random() * 30 + 50;
            const randomColor = `hsl(${randomHue}, ${randomSaturation}%, ${randomLightness}%)`;

            // ライトのスタイルを更新
            light.style.top = `${randomY}px`;
            light.style.left = `${randomX}%`;
            light.style.transform = `scale(${randomScale})`;
            light.style.opacity = randomOpacity.toString(); // opacityは文字列として指定
            light.style.background = `radial-gradient(circle, ${randomColor}, transparent)`;

            const randomDuration = Math.random() * 3 + 2;
            light.style.transition = `all ${randomDuration}s ease-in-out`;
        });

        // 4秒ごとに再度ランダム化
        setTimeout(updateLights, 4000);
    }

    // 初回実行
    updateLights();
}
