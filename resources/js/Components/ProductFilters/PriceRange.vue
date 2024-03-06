<template>
    <div>
        <div class="text-center mt-3">${{ lowerValue }} - ${{ upperValue }}</div>
        <div class="slider-container relative h-2 m-4">
            <div class="slider-track absolute bg-gray-300 h-2 w-full rounded cursor-pointer"
                @mousedown.stop="mousedown($event, 'track')"></div>
            <div class="slider-range absolute bg-blue-500 h-2 rounded pointer-events-none" :style="rangeStyle"></div>
            <div>
                <div class="thumb lower-thumb absolute bg-blue-600 h-4 w-4 rounded-full cursor-pointer -mt-1"
                    :style="lowerThumbStyle" @mousedown.stop="mousedown($event, 'lower')">
                </div>
                <div class="thumb upper-thumb absolute bg-blue-600 h-4 w-4 rounded-full cursor-pointer -mt-1"
                    :style="upperThumbStyle" @mousedown.stop="mousedown($event, 'upper')">
                </div>
            </div>
        </div>
        <button class="mt-4 p-2 rounded border bg-white hover:shadow-lg inline-block"
            @click="updateAndNavigate()">
            OK
        </button>

    </div>
</template>


<script setup>
import { ref, computed, onUnmounted } from 'vue';
import { router, usePage } from '@inertiajs/vue3';

const { props } = usePage();

const isDragging = ref(false);
const currentThumb = ref(null);

const minProductPrice = ref(0);
const maxProductPrice = ref(props.maxPrice); // Set this from the props passed by Inertia

const lowerValue = ref(parseInt(new URLSearchParams(window.location.search).get('priceFrom')) || minProductPrice.value);
const upperValue = ref(parseInt(new URLSearchParams(window.location.search).get('priceTo')) || maxProductPrice.value);

function updateAndNavigate() {
    const params = new URLSearchParams(window.location.search);
    params.set('priceFrom', lowerValue.value);
    params.set('priceTo', upperValue.value);
    const queryParams = Object.fromEntries(params);
    const url = route('products.index', queryParams);
    router.visit(url);
}

// Calculate thumb position based on value
const calculateThumbPosition = (value) => {
    return (value / props.maxPrice) * 100;
};

// Update value based on new thumb position
const updateValue = (clientX) => {
    const trackBounds = document.querySelector('.slider-track').getBoundingClientRect();
    let newPercentage = ((clientX - trackBounds.left) / trackBounds.width) * 100;
    newPercentage = Math.max(0, Math.min(newPercentage, 100)); // Constrain within 0 to 100%

    // Calculate the value based on the percentage and the actual price range
    const range = maxProductPrice.value - minProductPrice.value;
    const newValue = Math.round((newPercentage * range / 100) + minProductPrice.value);

    // Update the lower or upper value based on which thumb is being moved
    if (currentThumb.value === 'lower') {
        lowerValue.value = Math.min(newValue, upperValue.value);
    } else if (currentThumb.value === 'upper') {
        upperValue.value = Math.max(newValue, lowerValue.value);
    }
};

// Event handlers
const mousedown = (event, element) => {
    if (element === 'track') {
        currentThumb.value = getClosestThumb(event.clientX);
    } else {
        currentThumb.value = element;
    }
    isDragging.value = true;
    updateValue(event.clientX);

    window.addEventListener('mousemove', mousemove);
    window.addEventListener('mouseup', mouseup);
};

const mousemove = (event) => {
    if (!isDragging.value) return;
    updateValue(event.clientX);
};

const mouseup = () => {
    isDragging.value = false;
    currentThumb.value = null;

    window.removeEventListener('mousemove', mousemove);
    window.removeEventListener('mouseup', mouseup);
};

// Determine which thumb is closer to the click point
const getClosestThumb = (clickX) => {
    const trackBounds = document.querySelector('.slider-track').getBoundingClientRect();
    const lowerThumbX = trackBounds.left + (trackBounds.width * lowerValue.value / props.maxPrice);
    const upperThumbX = trackBounds.left + (trackBounds.width * upperValue.value / props.maxPrice);

    const lowerDistance = Math.abs(clickX - lowerThumbX);
    const upperDistance = Math.abs(clickX - upperThumbX);

    return lowerDistance < upperDistance ? 'lower' : 'upper';
};

onUnmounted(() => {
    window.removeEventListener('mousemove', mousemove);
    window.removeEventListener('mouseup', mouseup);
});

// Computed styles
const lowerThumbStyle = computed(() => {
    const percentage = calculateThumbPosition(lowerValue.value);
    return { left: `calc(${percentage}% - 8px)` };
});

const upperThumbStyle = computed(() => {
    const percentage = calculateThumbPosition(upperValue.value);
    return { left: `calc(${percentage}% - 8px)` };
});

const rangeStyle = computed(() => {
    const lowerPercentage = calculateThumbPosition(lowerValue.value);
    const upperPercentage = calculateThumbPosition(upperValue.value);
    return { left: `${lowerPercentage}%`, right: `${100 - upperPercentage}%` };
});

</script>
