<template>
    <div>
        <h2>
            WELCOME TO PRESCRIBE
        </h2>
        <img :src="'storage/images/'+imageName" style="max-width: 100%; max-height: 100%; height: auto;">
    </div>
</template>

<script>
    export default {
        data () {
            return {
                imageName: imageName
            }
        },
    }
</script>
