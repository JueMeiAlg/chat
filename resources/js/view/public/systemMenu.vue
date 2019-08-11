<template>
    <div id="systemMenu" style="display: none" @contextmenu.prevent="openSystemMenu">
        <div>菜单</div>
    </div>
</template>

<script>
    export default {
        name: "systemMenu",
        methods:{
            openSystemMenu(e){
                let menu = window.document.getElementById('systemMenu');
                if (menu.style.display == '') {
                    menu.style.display = 'none';
                } else {
                    //根据事件对象中鼠标点击的位置，进行定位
                    menu.style.left = e.layerX  + 'px';
                    menu.style.top = e.clientY + 'px';
                    menu.style.display = '';
                }
            }
        }
    }
</script>

<style scoped>
    #systemMenu {
        position: absolute;
    }
</style>