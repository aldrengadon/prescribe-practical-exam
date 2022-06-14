<template>
    <div class="alert alert-danger" fade>
        <div class="bg-red alert-icon">
            <i class="glyph-icon icon-times"></i>
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
        name: 'notification-fail',
        props: {
            title: String,
            message: String
        }
    }
</script>
