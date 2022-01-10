"use strict";
function sphere_render ( selector ) {
    var renderer, scene, camera, dots, dots, dots_2, sphere, sphere_2, coeff;
    var second_sphere = jQuery(selector).parent().data('second-sphere');
    var color = jQuery(selector).parent().data('sphere-color');
    color = color.replace(/#/g, '');
    color = parseInt(color, 16);

    var width = jQuery(selector).parent().data('sphere-width');
    var ww = width,
        wh = width;
    var width = document.body.offsetWidth;
    var density = 200;
    var density_2 = 100;
    var mouse = {x:1,y:1};

    switch (true) {
        case width < 450:
            coeff = 0.4;
            break;
        case width < 767:
            coeff = 0.6;
            break;
        case width < 1025:
            coeff = 0.8;
            break;
        case width < 1281:
            coeff = 1;
            break;
        default:
            coeff = 1;
            break;
    }

    wh = wh*coeff;
    ww = ww*coeff;
    
    function init(){
        renderer = new THREE.WebGLRenderer({
            canvas: selector,
            antialias: true,
            alpha: true
        });
        renderer.setClearColor(0x000020, 0);
        renderer.setSize(ww, wh);

        scene = new THREE.Scene();

        camera = new THREE.PerspectiveCamera(50, ww / wh, 0.1, 10000);
        camera.position.z = 500;
        scene.add(camera);

        var geometry = new THREE.Geometry();
        for(var i=0;i<density;i++){
            geometry.vertices.push(new THREE.Vector3(0,0,0));
        }
        var material = new THREE.PointsMaterial({color: color, size:3, transparent:true, opacity:0.5});
        dots = new THREE.Points(geometry, material);
        if (second_sphere) {scene.add(dots);}

        var geometry_33 = new THREE.Geometry();
        for(var i=0;i<density;i++){
            geometry_33.vertices.push(new THREE.Vector3(0,0,0));
        }
        var material_33 = new THREE.PointsMaterial({color: color, size:4, transparent:true, opacity:0.7});
        dots_2 = new THREE.Points(geometry_33, material_33);
        // scene.add(dots_2);

        var geometry = new THREE.IcosahedronGeometry(150, 2);
        var material = new THREE.MeshBasicMaterial( {color: color, transparent:true, opacity:0.7, wireframe:true} );
        sphere = new THREE.Mesh( geometry, material );
        if (second_sphere) {scene.add( sphere );}
        

        var geometry_2 = new THREE.IcosahedronGeometry(200, 1);
        var material_2 = new THREE.MeshBasicMaterial( {color: color, transparent:true, opacity:0.2, wireframe:true} );
        sphere_2 = new THREE.Mesh( geometry_2, material_2 );
        scene.add( sphere_2 );

        requestAnimationFrame(render);
    }


    function onResize(){
        ww = window.innerWidth;
        wh = window.innerHeight;
        camera.aspect = ww / wh;
        camera.updateProjectionMatrix();
        renderer.setSize( ww, wh );
    }

    function createDots(a){

        for(var i=0;i<density_2;i++){
            var theta = (i/density_2) * (mouse.x*100);
            var delta = (i / density_2 - 0.5) * Math.PI * (mouse.y);
            var x = 150 * Math.cos(delta) * Math.cos(theta);
            var y = 150 * Math.cos(delta) * Math.sin(theta);
            var z = 150 * Math.sin(delta);

            dots.geometry.vertices[i].x = x;
            dots.geometry.vertices[i].y = y;
            dots.geometry.vertices[i].z = z;
        }
        dots.geometry.verticesNeedUpdate = true;

    }

    function createDots_2(a){

        for(var i=0;i<density;i++){
            var theta = (i/density) * (mouse.x*100);
            var delta = (i / density - 0.5) * Math.PI * (mouse.y);
            var x = 200 * Math.cos(delta) * Math.cos(theta);
            var y = 200 * Math.cos(delta) * Math.sin(theta);
            var z = 200 * Math.sin(delta);

            dots_2.geometry.vertices[i].x = x;
            dots_2.geometry.vertices[i].y = y;
            dots_2.geometry.vertices[i].z = z;
        }
        dots_2.geometry.verticesNeedUpdate = true;

    }

    function render(a){
        requestAnimationFrame(render);

        dots.rotation.x += 0.002;
        dots.rotation.y += 0.002;
        dots.rotation.z -= 0.002;

        dots_2.rotation.x -= 0.001;
        dots_2.rotation.y -= 0.001;
        dots_2.rotation.z += 0.001;

        sphere.rotation.x += 0.002;
        sphere.rotation.y += 0.002;
        sphere.rotation.z -= 0.002;

        sphere_2.rotation.x -= 0.001;
        sphere_2.rotation.y -= 0.001;
        sphere_2.rotation.z += 0.001;

        createDots(a);
        createDots_2(a);

        renderer.render(scene, camera);
    }

    init();
}
jQuery(".blockchain-earth canvas").each(function(){
    sphere_render(this);
});