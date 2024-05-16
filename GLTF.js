// Création de la scène
const scene = new THREE.Scene();
scene.background = null;

// Création de la caméra
const camera = new THREE.PerspectiveCamera(40, window.innerWidth / window.innerHeight, 0.1, 1000);



// Création du rendu
const canvasWidth = 900;
const canvasHeight = 320;
const canvas = document.getElementById('renderCanvas');
const renderer = new THREE.WebGLRenderer({ canvas, alpha: true });
renderer.setClearColor(0x000000, 0);

function resizeRenderer() {
    renderer.setSize(canvasWidth, canvasHeight);
    camera.aspect = canvasWidth / canvasHeight;
    renderer.antialias = true;
    renderer.shadowMap.enabled = true;
    renderer.precision = "highp";
    renderer.setPixelRatio(window.devicePixelRatio);
    camera.updateProjectionMatrix();
}

resizeRenderer();

// Redimensionner le rendu lorsque la fenêtre du navigateur est redimensionnée
window.addEventListener('resize', resizeRenderer);

// Chargement du modèle GLTF
const loader = new THREE.GLTFLoader();
loader.load(
    '/gltf/scene.gltf',
    function (gltf) {
        const zoomInButton = document.getElementById('zoomIn');
        const zoomOutButton = document.getElementById('zoomOut');
        function zoomIn() {
            camera.position.z -= 10;
        }

        function zoomOut() {
            camera.position.z += 10;
        }

        zoomInButton.addEventListener('click', zoomIn);
        zoomOutButton.addEventListener('click', zoomOut);

        gltf.scene.scale.set(20, 20, 20);

        gltf.scene.traverse(function (child) {
            if (child.isMesh) {
                child.material.transparent = false;
                child.material.opacity = 1;
                child.material.magFilter = THREE.NearestFilter;
            }
        });

        camera.aspect = canvasWidth / canvasHeight;
        camera.updateProjectionMatrix();

        const boundingBox = new THREE.Box3().setFromObject(gltf.scene);
        const boundingBoxSize = new THREE.Vector3();
        boundingBox.getSize(boundingBoxSize);
        const maxDimension = Math.max(boundingBoxSize.x, boundingBoxSize.y, boundingBoxSize.z);
        const distanceFactor = 1;
        const distance = maxDimension * distanceFactor;
        const center = new THREE.Vector3();
        boundingBox.getCenter(center);
        camera.position.set(center.x, center.y, center.z + distance);
        camera.lookAt(center);

        scene.add(gltf.scene);

        const light = new THREE.HemisphereLight(0xffffff, 0x000000, 3.1);
        scene.add(light);


        let isDragging = false;
        let isUserInteracting = false;
        let previousMousePosition = { x: 0, y: 0 };

        document.addEventListener('mousedown', onMouseDown);
        document.addEventListener('mouseup', onMouseUp);
        document.addEventListener('mousemove', onMouseMove);
        document.addEventListener('wheel', onWheel);

        function onMouseDown(event) {
            isUserInteracting = true;
            isDragging = true;
            previousMousePosition.x = event.clientX;
            previousMousePosition.y = event.clientY;
        }

        function onMouseUp() {
            isDragging = false;
            isUserInteracting = false;
        }

        function onMouseMove(event) {
            if (isUserInteracting) {
                const deltaX = event.clientX - previousMousePosition.x;
                const deltaY = event.clientY - previousMousePosition.y;

                // Manipulez la caméra ou la scène en fonction du mouvement de la souris ou du toucher
                // Par exemple, pour faire tourner la scène autour de son axe y, vous pouvez utiliser :
                gltf.scene.rotation.y += deltaX * 0.01;
                gltf.scene.rotation.x -= deltaY * 0.01;

                previousMousePosition.x = event.clientX;
                previousMousePosition.y = event.clientY;
            }
        }
        function onWheel(event) {
            event.preventDefault();

            const delta = Math.sign(event.deltaY);
            const zoomSpeed = 0.1;

            camera.position.z -= delta * zoomSpeed;
            camera.position.z = Math.max(camera.position.z, 1);
            camera.position.z = Math.min(camera.position.z, 100);
        }

        document.addEventListener('wheel', onWheel, { passive: false });

        function onTouchStart(event) {
            event.preventDefault();
            const touch = event.touches[0];
            previousMousePosition.x = touch.clientX;
            previousMousePosition.y = touch.clientY;
        }

        function onTouchMove(event) {
            event.preventDefault(); // Empêcher le défilement de la page
            if (event.touches.length === 1) {
                const touch = event.touches[0];
                const deltaX = touch.clientX - previousMousePosition.x;
                const deltaY = touch.clientY - previousMousePosition.y;

                gltf.scene.rotation.y += deltaX * 0.01;
                gltf.scene.rotation.x -= deltaY * 0.01;

                previousMousePosition.x = touch.clientX;
                previousMousePosition.y = touch.clientY;
            } else if (event.touches.length === 2) {
                const touch1 = event.touches[0];
                const touch2 = event.touches[1];
                const distance = Math.sqrt(
                    Math.pow(touch1.clientX - touch2.clientX, 2) +
                    Math.pow(touch1.clientY - touch2.clientY, 2)
                );
                const delta = distance - previousTouchDistance;
                const zoomSpeed = 0.1;

                camera.position.z -= delta * zoomSpeed;
                camera.position.z = Math.max(camera.position.z, 1);
                camera.position.z = Math.min(camera.position.z, 100);

                previousTouchDistance = distance;
            }
            return false;
        }

        function onPinchStart(event) {
            event.preventDefault();
            const touch1 = event.touches[0];
            const touch2 = event.touches[1];
            previousTouchDistance = Math.sqrt(
                Math.pow(touch1.clientX - touch2.clientX, 2) +
                Math.pow(touch1.clientY - touch2.clientY, 2)
            );
        }

        document.addEventListener('touchstart', onTouchStart);
        document.addEventListener('touchmove', onTouchMove);
        document.addEventListener('touchstart', onPinchStart);


        function animate() {
            if (!isUserInteracting) {
                gltf.scene.rotation.y += 0.005; // ou toute autre valeur de rotation souhaitée
            }
            requestAnimationFrame(animate);
            renderer.render(scene, camera);
        }
        animate();
    },
    undefined,
    function (error) {
        console.error(error);
    },


);


