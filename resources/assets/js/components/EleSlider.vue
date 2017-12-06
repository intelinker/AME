<template>
    <div class="block">
        <el-slider
                v-model="value"
                :step="10"
                show-stops
                show-input>
        </el-slider>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                value: 0
            }
        }
    }
</script>
