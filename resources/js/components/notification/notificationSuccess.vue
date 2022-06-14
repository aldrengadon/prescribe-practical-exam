<template>
    <div class="alert alert-success">
        <div class="bg-green alert-icon">
            <i class="glyph-icon icon-check"></i>
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
        name: 'notification-success',
        props: {
            title: String,
            message: String
        }
    }
</script>
