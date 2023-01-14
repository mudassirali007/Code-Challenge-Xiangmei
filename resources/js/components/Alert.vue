<template>
<!--    <div >-->
<!--        <v-alert> {{ message }} </v-alert>-->
<!--    </div>-->
    <v-alert :type="type">
        {{ message }}
    </v-alert>
</template>

<script>
export default {
    name: "Alert",
    props: {
        type: {
            type: String,
            default: 'success'
        },
        message: {
            type: String,
            default: 'Success.'
        },
    },
    created () {
        setTimeout(() => {
            this.$emit('alertTimeout')
        }, 5000);

    },
}
</script>

<style scoped>
.v-alert {
    position: fixed;
    right: 0%;
    transform: translate(-50%, -50%);
    margin: 0 auto;
    z-index: 10;
}
</style>
