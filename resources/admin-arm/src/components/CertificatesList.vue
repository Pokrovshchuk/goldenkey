<template>
    <section class="certificates-list">
        <div class="certificates-list__table">
            <div class="certificates-list__head">
                <p
                    class="
            certificates-list__head-title
            certificates-list__head-title--hall-code
          "
                >
                    Код <br/>
                    Бизнес-зала
                </p>
                <p
                    class="
            certificates-list__head-title
            certificates-list__head-title--hall-name
          "
                >
                    Наименование Бизнес-зала
                </p>
                <p
                    class="
            certificates-list__head-title
            certificates-list__head-title--certificate-code
          "
                >
                    Номер сертификата
                </p>
                <p
                    class="
            certificates-list__head-title certificates-list__head-title--name
          "
                >
                    ФИО
                </p>
                <p
                    class="
            certificates-list__head-title certificates-list__head-title--date
          "
                >
                    Дата
                </p>
                <p
                    class="
            certificates-list__head-title certificates-list__head-title--time
          "
                >
                    Время
                </p>
                <p
                    class="
            certificates-list__head-title
            certificates-list__head-title--status
            certificates-list__head-title--error
            certificates-list__head-title--success
          "
                >
                    Статус сертификата
                </p>
            </div>
            <ul class="certificates-list__list">
                <li
                    v-for="cert in certificates"
                    :key="cert.id"
                    class="certificates-list__item"
                >
                    <p class="certificates-list__cell certificates-list__cell--hall-code">
                        <template v-if="cert.halls">
                            {{ cert.halls.prefix.toUpperCase() }}
                        </template>
                    </p>
                    <p class="certificates-list__cell certificates-list__cell--hall-name">
                        {{ hallName }}
                    </p>
                    <p
                        class="
              certificates-list__cell certificates-list__cell--certificate-code
            "
                    >
                        {{ cert.id ? cert.id : '' }}
                    </p>
                    <p class="certificates-list__cell certificates-list__cell--name">
                        <template v-if="cert.user_name">
                            {{ formatUserName(cert.user_name) }}
                        </template>
                        <template v-else>
                            Без имени
                        </template>
                    </p>
                    <p class="certificates-list__cell certificates-list__cell--date">
                        {{
                            cert.start_time
                                ? $moment(cert.start_time).format('DD.MM.yyyy')
                                : ''
                        }}
                    </p>
                    <p class="certificates-list__cell certificates-list__cell--time">
                        {{
                            cert.start_time ? $moment(cert.start_time).format('HH:mm') : ''
                        }}
                    </p>
                    <p
                        class="
              certificates-list__cell
              certificates-list__cell--status
            "
                        :class="{
                        'certificates-list__cell--success': cert.status==='active',
                        'certificates-list__cell--inactive': cert.status==='inactive',
                        'certificates-list__cell--error': ['left', 'expired'].includes(cert.status),
                        }"
                    >
                        {{ getStatusMsg(cert.status) }}
                    </p>
                </li>

            </ul>
            <div class="certificates-list__controls">
                <button class="certificates-list__button button">Загрузить еще</button>
                <Pagination :hall-data="hallData" :data-callback="paginate"/>
            </div>
        </div>
    </section>
</template>
<script>
import Pagination from './Pagination.vue'

export default {
    components: {
        Pagination,
    },
    computed: {
        certificates() {
            return this.$store.getters['getRegistryCertificates']
        },
        hallData() {
            return this.$store.getters['getRegistryData']
        },
        hallName() {
            return this.$store.getters['getRegistryName']
        },
    },
    methods: {
        paginate({data}) {
            this.$store.commit('setRegistryData', {data})
        },
        getStatusMsg(status) {
            switch (status) {
                case 'inactive':
                    return 'Не активирован'
                case 'active':
                    return 'Активирован'
                case 'expired':
                    return 'Истёк срок'
                case 'left':
                    return 'Покинул зал'
            }
        },
        formatUserName(userName) {
            if (this.isJson(userName)) {
                userName = JSON.parse(userName)
                userName = userName.join(', ')
            }

            return userName
        },
        isJson(item) {
            item = typeof item !== "string"
                ? JSON.stringify(item)
                : item;

            try {
                item = JSON.parse(item);
            } catch (e) {
                return false;
            }

            if (typeof item === "object" && item !== null) {
                return true;
            }

            return false;
        },
    },
}
</script>
