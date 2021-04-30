<template>
    <div>
        <img src="../../img/rentaled.png" class="rentaled" />
        <span class="rentaled-text" >レンタル中</span>
    </div>
</template>

<script>
export default {};
</script>

<style>
.item-img .rentaled {
    position: absolute;
    top: 0;
    left: 0;
}
.item-img .rentaled-text {
    position: absolute;
    font-size: 9px;
    font-weight: bold;
    top: 14px;
    left: -5px;
    color: white;
    transform: rotate(-45deg);
    -moz-transform: rotate(-45deg);
    -webkit-transform: rotate(-45deg);
}
</style>
