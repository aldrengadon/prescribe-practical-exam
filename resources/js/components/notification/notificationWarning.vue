<template>
    <div class="alert alert-warning">
        <div class="bg-orange alert-icon">
            <i class="glyph-icon icon-warning"></i>
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
        name: 'notification-warning',
        props: {
            title: String,
            message: String
        }
    }
</script>
