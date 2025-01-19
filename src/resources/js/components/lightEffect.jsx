export function randomizeLights() {
    const lightEffects = document.querySelectorAll('.light-effect');

    // `min-height` が適用されている要素を取得（例: body 要素や特定のコンテナ）
    const container = document.querySelector('.index_inner');


    function updateLights() {
        // コンテナの高さを取得
        const containerHeight = container.offsetHeight;

        lightEffects.forEach(light => {
            const randomX = Math.random() * 100;
            const randomY = Math.random() * containerHeight;
            const randomScale = Math.random() * 1 + 1;
            const randomOpacity = Math.random() * 0.4 + 0.3;
            const randomHue = Math.floor(Math.random() * 360);
            const randomSaturation = Math.random() * 50 + 50;
            const randomLightness = Math.random() * 30 + 50;
            const randomColor = `hsl(${randomHue}, ${randomSaturation}%, ${randomLightness}%)`;

            light.style.top = `${randomY}px`;
            light.style.left = `${randomX}%`;
            light.style.transform = `scale(${randomScale})`;
            light.style.opacity = randomOpacity;
            light.style.background = `radial-gradient(circle, ${randomColor}, transparent)`;

            const randomDuration = Math.random() * 3 + 2;
            light.style.transition = `all ${randomDuration}s ease-in-out`;
        });

        setTimeout(updateLights, 4000);
    }

    updateLights();
}


