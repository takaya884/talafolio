<script setup>
defineProps({
    to: {
        type: Object,
        required: true,
    },
});

</script>
<template>
    <button> <router-link :to="to" class="btn bg-white btn-arrow"></router-link></button>
</template>






