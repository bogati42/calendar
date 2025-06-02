<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive 3D Globe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            margin: 0;
            overflow: hidden;
            /* Flexbox not strictly needed for this layout but good for overall page */
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            position: relative; /* Needed for absolute positioning of children */
        }
        #globe-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1; /* Globe behind the link */
        }
        .label {
            position: absolute;
            color: white;
            font-family: Arial, sans-serif;
            font-size: 12px;
            pointer-events: none; /* Allows clicks to pass through to the globe */
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
            transition: opacity 0.3s;
            z-index: 2; /* Labels above the globe */
        }

        /* Styles for the "Go to Main Page" link at the bottom */
        .main-page-link {
            position: absolute; /* Position over the globe */
            bottom: 20px; /* 20px from the bottom */
            left: 50%; /* Center horizontally */
            transform: translateX(-50%); /* Adjust for exact centering */
            z-index: 10; /* Ensure it's on top of everything */
            background-color: rgba(0, 0, 0, 0.6); /* Semi-transparent dark background */
            padding: 12px 25px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(5px); /* Optional: adds a frosted glass effect */
        }

        .main-page-link a {
            color: #d1d5db; /* Light gray text, similar to Tailwind's gray-300 */
            text-decoration: none;
            font-size: 1rem;
            font-weight: 600; /* Semi-bold */
            transition: color 0.3s ease, transform 0.2s ease;
            display: block; /* Make the whole padding area clickable */
        }

        .main-page-link a:hover {
            color: #ffffff; /* White text on hover */
            transform: scale(1.05); /* Slight enlargement on hover */
        }
    </style>
</head>
<body class="bg-gray-900">
    <div id="globe-container"></div>

    <div class="main-page-link">
        <a href="http://34.30.240.75/">Go to Main Page</a>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>

    <script>
        let scene, camera, renderer, globe, controls;
        const labels = [];
        const labelContainer = document.createElement('div');
        labelContainer.style.position = 'absolute';
        labelContainer.style.top = '0';
        labelContainer.style.left = '0';
        labelContainer.style.width = '100%';
        labelContainer.style.height = '100%';
        labelContainer.style.pointerEvents = 'none'; // Pass mouse events through to globe
        labelContainer.style.zIndex = '2'; // Ensure labels are above the globe

        async function init() {
            // Scene setup
            scene = new THREE.Scene();

            // Camera setup
            camera = new THREE.PerspectiveCamera(45, window.innerWidth/window.innerHeight, 0.1, 1000);
            camera.position.z = 2.5;

            // Renderer setup
            renderer = new THREE.WebGLRenderer({ antialias: true });
            renderer.setSize(window.innerWidth, window.innerHeight);
            renderer.setPixelRatio(window.devicePixelRatio);
            document.getElementById('globe-container').appendChild(renderer.domElement);
            document.body.appendChild(labelContainer); // Append label container to body

            // Add controls
            controls = new THREE.OrbitControls(camera, renderer.domElement);
            controls.enableDamping = true;
            controls.dampingFactor = 0.05;
            controls.rotateSpeed = 0.5;

            // Create Earth
            createEarth();
            createAtmosphere();
            await addGeographicLabels(); // This will not add any labels since the array is empty
            addLights();

            // Event listeners
            window.addEventListener('resize', onWindowResize);
            window.addEventListener('click', onGlobeClick);
        }

        async function addGeographicLabels() {
            // All continent and ocean data has been removed. The array is now empty.
            const geographicFeatures = [];

            geographicFeatures.forEach(feature => {
                createLabel(feature.name, feature.coords[0], feature.coords[1], feature.type);
            });
        }

        function createLabel(text, lat, lng, type = 'country') {
            const label = document.createElement('div');
            label.className = 'label';
            label.textContent = text;
            label.style.color = type === 'ocean' ? '#88bbff' : '#ffffff';
            label.style.fontSize = type === 'continent' ? '14px' : '12px';
            label.style.fontWeight = type === 'continent' ? 'bold' : 'normal';
            labelContainer.appendChild(label); // Append to labelContainer

            labels.push({
                element: label,
                lat: THREE.MathUtils.degToRad(lat),
                lng: THREE.MathUtils.degToRad(lng),
                type: type
            });
        }

        function updateLabels() {
            const vector = new THREE.Vector3();
            const widthHalf = window.innerWidth / 2;
            const heightHalf = window.innerHeight / 2;

            labels.forEach(label => {
                // Convert spherical coordinates to 3D position
                const phi = Math.PI/2 - label.lat;
                const theta = -label.lng;
                vector.setFromSphericalCoords(1, phi, theta);

                // Get screen position
                vector.project(camera);
                const x = (vector.x * widthHalf) + widthHalf;
                const y = -(vector.y * heightHalf) + heightHalf;

                // Update label position and visibility
                label.element.style.left = `${x}px`;
                label.element.style.top = `${y}px`;

                // Calculate visibility (only show labels facing camera)
                const dot = vector.clone().applyMatrix4(globe.matrixWorld).sub(camera.position).normalize().dot(globe.position.clone().normalize());

                // Adjust dot product logic to check if point is on the front side of the globe relative to camera
                const globeNormal = vector.clone().normalize(); // Normal vector from globe's center to label point
                const cameraDirection = new THREE.Vector3();
                camera.getWorldDirection(cameraDirection); // Get camera's forward direction

                // If the dot product of the normal at the label point and the vector from camera to label point is positive, it's visible
                // Or simply check if the label point is "in front" of the camera's current viewing frustum plane.
                // A simpler approximation is checking the Z component after projection:
                label.element.style.opacity = (vector.z < 1) ? 1 : 0; // If Z is less than 1, it's in front of the camera's near plane (normalized device coordinates)
            });
        }

        function createEarth() {
            const geometry = new THREE.SphereGeometry(1, 64, 64);
            const material = new THREE.MeshPhongMaterial({
                map: new THREE.TextureLoader().load('https://threejs.org/examples/textures/planets/earth_atmos_2048.jpg'),
                bumpScale: 0.05,
                specular: new THREE.Color('grey'),
                shininess: 5
            });

            globe = new THREE.Mesh(geometry, material);
            scene.add(globe);
        }

        function createAtmosphere() {
            const geometry = new THREE.SphereGeometry(1.02, 64, 64);
            const material = new THREE.MeshPhongMaterial({
                color: 0x88bbff,
                transparent: true,
                opacity: 0.15,
                side: THREE.BackSide
            });
            atmosphere = new THREE.Mesh(geometry, material);
            scene.add(atmosphere);
        }

        function addLights() {
            const ambientLight = new THREE.AmbientLight(0x404040);
            scene.add(ambientLight);

            const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
            directionalLight.position.set(5, 3, 5);
            scene.add(directionalLight);
        }

        function onGlobeClick(event) {
            // Convert mouse position to normalized device coordinates
            const mouse = new THREE.Vector2();
            mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
            mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;

            // Raycast to find clicked location
            const raycaster = new THREE.Raycaster();
            raycaster.setFromCamera(mouse, camera);

            const intersects = raycaster.intersectObject(globe);
            if (intersects.length > 0) {
                const point = intersects[0].point;
                const latLng = getLatLngFromVector(point);
                console.log('Clicked at:', latLng);
            }
        }

        function getLatLngFromVector(vector) {
            const phi = Math.acos(vector.y / 1);
            const theta = Math.atan2(vector.z, vector.x);
            return {
                lat: THREE.MathUtils.radToDeg(phi - Math.PI/2),
                lng: THREE.MathUtils.radToDeg(theta + Math.PI)
            };
        }

        function onWindowResize() {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        }

        function animate() {
            requestAnimationFrame(animate);
            controls.update();
            updateLabels(); // Update labels for visibility and position
            globe.rotation.y += 0.0002;
            renderer.render(scene, camera);
        }

        window.onload = () => {
            init();
            animate();
        };
    </script>
</body>
</html>
