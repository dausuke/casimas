<template>
    <div class="Top">
        <topHeader />
        <HelloWorld />
    </div>
</template>

<script>
// @ is an alias to /src
import HelloWorld from '@/components/HelloWorld.vue';
import topHeader from '../components/topPageHeader';

export default {
    name: 'Home',
    components: {
        HelloWorld,
        topHeader,
    },
};
</script>
