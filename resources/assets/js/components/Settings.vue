<template>
    <div class="row">
        <div class="small-12 columns">
            <div class="panel nmt">
                <div class="row">
                    <div class="medium-4 columns">
                        <p>Selected queue:</p>
                        <select disabled="disabled">
                            <option selected="selected">VitalityX Main</option>
                        </select>
                    </div>
                    <div class="medium-4 columns">
                        <p>Preferred Timezone:</p>
                        <select disabled="disabled">
                            <option selected="selected">Eastern Standard</option>
                        </select>
                    </div>
                    <div class="medium-4 columns">
                        <p>Play sounds:</p>
                        <input type="checkbox" checked="checked" /> Enabled
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        mounted() {
            // console.log('Component mounted.')
        }
    }
</script>
