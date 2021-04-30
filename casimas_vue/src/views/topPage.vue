<template>
    <div class="Top">
        <topHeader />
        <topPageContent />
    </div>
</template>

<script>
// @ is an alias to /src
import topPageContent from '@/components/topPageContent.vue';
import topHeader from '../components/topPageHeader';

export default {
    name: 'Home',
    components: {
        topPageContent,
        topHeader,
    },
};
</script>
