<template>
    <div class="flip-card">
        <div class="flip-card-inner">
            <div class="flip-card-front">
                <img :src="item.image_url" :alt="item.name" v-if="item.image_url">
                <img src="/images/no-image.png" alt="no image available" v-else>
                <span class="abv">{{ item.abv }}%</span>
            </div>
            <div class="flip-card-back">
                <h2>{{ item.name }}</h2>
                <p>{{ item.description }}</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Beer",
    props: {
        item: Object
    }
}
</script>

<style scoped>
    .flip-card {
        background-color: transparent;
        width: 100%;
        height: 300px;
        perspective: 1000px;
    }

    .flip-card-inner {
        position: relative;
        width: 100%;
        height: 100%;
        text-align: center;
        transition: transform 0.8s;
        transform-style: preserve-3d;
    }

    .flip-card:hover .flip-card-inner {
        transform: rotateY(180deg);
    }

    .flip-card-front, .flip-card-back {
        position: absolute;
        width: 100%;
        height: 100%;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        padding: 15px;
    }

    .flip-card-front {
        background-color: #fff;
        border: 1px solid #dee2e6;
        color: black;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .flip-card-front img {
        max-height: 100%;
        max-width: 100%;
    }

    .flip-card-back {
        background-color: #fff;
        border: 1px solid #dee2e6;
        color: black;
        transform: rotateY(180deg);
        overflow-y: auto;
    }

    .flip-card h2 {
        font-size: 24px;
        font-weight: 700;
    }

    .flip-card-back p {
        font-size: 16px;
        line-height: 1.2;
    }

    .abv {
        position: absolute;
        top: 5px;
        right: 5px;
        width: 50px;
        height: 50px;
        line-height: 50px;
        border-radius: 50%;
        background-color: gold;
        color: black;
        font-size: 16px;
        font-weight: 500;
        text-align: center;
    }
</style>