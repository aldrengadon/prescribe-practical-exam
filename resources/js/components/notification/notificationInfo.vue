<template>
    <div class="alert alert-info">
        <div class="bg-black alert-icon">
            <i class="glyph-icon icon-info"></i>
        </div>
        <div class="alert-content">
            <h4 class="alert-title"> {{ title }} </h4>
            <p> {{ message }} </p>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            // console.log('Component mounted.')
        },
        name: 'notification-info',
        props: {
            title: String,
            message: String
        }
    }
</script>
