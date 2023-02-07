<template>
    <div class="filters">
        <input
            type="text"
            name="search"
            placeholder="Поиск по номеру сертификата, ФИО именного сертификата"
            class="filters__search"
            v-model="search"
        />
        <div class="filters__controls">
            <h3 class="filters__subtitle">Период</h3>
            <ul class="filters__list">
                <li class="filters__item">
                    <input
                        type="radio"
                        name="period"
                        id="yesterday-filter"
                        value="yesterday-filter"
                        v-model="periods"
                    />
                    <label class="filters__label" for="yesterday-filter">Вчера</label>
                </li>
                <li class="filters__item">
                    <input
                        type="radio"
                        name="period"
                        id="today-filter"
                        value="today-filter"
                        v-model="periods"
                        checked
                    />
                    <label class="filters__label" for="today-filter">Сегодня</label>
                </li>
                <li class="filters__item">
                    <input
                        type="radio"
                        name="period"
                        id="month-filter"
                        value="month-filter"
                        v-model="periods"
                    />
                    <label class="filters__label" for="month-filter">Месяц</label>
                </li>
                <li class="filters__item">
                    <input
                        type="radio"
                        name="period"
                        id="year-filter"
                        value="year-filter"
                        v-model="periods"
                    />
                    <label class="filters__label" for="year-filter">Год</label>
                </li>
                <li class="filters__item">
                    от
                    <DatePicker
                        class="filters__date-picker"
                        v-model="timeFrom"
                        mode="date"
                    >
                        <template v-slot="{ inputValue, inputEvents }">
                            <input
                                class="filters__date-input"
                                :value="inputValue"
                                v-on="inputEvents"
                                placeholder="дд.мм.гггг"
                            />
                        </template>
                    </DatePicker>
                </li>
                <li class="filters__item">
                    до
                    <DatePicker class="filters__date-picker" v-model="timeTo" mode="date">
                        <template v-slot="{ inputValue, inputEvents }">
                            <input
                                class="filters__date-input"
                                :value="inputValue"
                                v-on="inputEvents"
                                placeholder="дд.мм.гггг"
                            />
                        </template>
                    </DatePicker>
                </li>
            </ul>
        </div>
        <div class="filters__controls">
            <h3 class="filters__subtitle">Статус</h3>
            <ul class="filters__list">
                <li class="filters__item">
                    <input v-model="status" value="all" type="radio" name="status" id="all-filter"/>
                    <label class="filters__label" for="all-filter">Все</label>
                </li>
                <li class="filters__item">
                    <input v-model="status" value="active" type="radio" name="status" id="active-filter" checked/>
                    <label class="filters__label" for="active-filter"
                    >Активированные</label
                    >
                </li>
                <li class="filters__item">
                    <input v-model="status" type="radio" value="inactive" name="status" id="inactive-filter"/>
                    <label class="filters__label" for="inactive-filter">Не активированые</label>
                </li>
                <li class="filters__item">
                    <input v-model="status" type="radio" value="left" name="status" id="left-filter"/>
                    <label class="filters__label" for="left-filter">Покинул</label>
                </li>
                <li class="filters__item">
                    <input v-model="status" type="radio" value="expired" name="status" id="expired-filter"/>
                    <label class="filters__label" for="expired-filter">Истек</label>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            timeFrom: null,
            timeTo: null,
            period: null,
            status: 'active',
            periods: 'today-filter',
            search: '',
        }
    },
    mounted() {
        this.setPeriod()
    },
    watch: {
        timeFrom(newV) {
            if (newV || this.timeFrom || this.timeTo) {
                this.periods = ''
            }
            this.setPeriod()
        },
        timeTo(newV) {
            if (newV || this.timeFrom || this.timeTo) {
                this.periods = ''
            }
            this.setPeriod()
        },
        periods(newV) {
            if (newV) {
                this.timeFrom = null
                this.timeTo = null
            }
            this.setPeriod()
        },
        status() {
            this.setPeriod()
        },
        search() {
            this.setPeriod()
        },
    },
    methods: {
        setPeriod() {
            let query = '?'
            
            if (this.periods) { 
                switch (this.periods) {
                    case 'yesterday-filter': {
                        let day = this.$moment(new Date()).add(-1, 'days').format('DD-MM-YYYY')
                        query = query + 'date_from=' + day + '&date_to=' + day
                        break
                    }
                    case 'today-filter': {
                        let day = this.$moment(new Date()).format('DD-MM-YYYY')
                        query = query + 'date_from=' + day + '&date_to=' + day
                        break
                    }
                    case 'month-filter': {
                        let month_start = this.$moment(new Date()).startOf('month').format('DD-MM-YYYY')
                        let month_end = this.$moment(new Date()).endOf('month').format('DD-MM-YYYY')
                        query = query + 'date_from=' + month_start + '&date_to=' + month_end
                        break
                    }
                    case 'year-filter': {
                        let year_start = this.$moment(new Date()).startOf('year').format('DD-MM-YYYY')
                        let year_end = this.$moment(new Date()).endOf('year').format('DD-MM-YYYY')
                        query = query + 'date_from=' + year_start + '&date_to=' + year_end
                        break
                    }
                }
            }

            if (this.timeFrom) {
                query = query + 'date_from=' + this.$moment(this.timeFrom).format('DD-MM-YYYY')
            }
            if (this.timeTo) {
                query = query + '&date_to=' + this.$moment(this.timeTo).format('DD-MM-YYYY')
            }


            if (this.status !== 'all') {
                query = query + '&status=' + this.status
            }

            if(this.search) {
                query += '&search=' + this.search
            }


            this.$eventBus.$emit('set-filters', {query})
            this.$store.dispatch('filterRegistryData', query)
        },
    },
}
</script>
