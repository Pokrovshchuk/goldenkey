<template>
    <main class="page-main">
        <div class="page-main__wrapper">
            <section class="page-main__section page-main__section--mw100">
                <div class="page-main__flex-row">
                    <button
                        class="page-main__back-button button-alternate"
                        @click="toMain"
                    >
                        <SvgIcon name="arrow" className="page-main__icon-arrow"/>
                        Назад на
                        главную
                    </button>
                    <h1 class="page-main__title page-main__title--m0">
                        Реестр сертификатов
                    </h1>
                    <p class="page-main__hall">
                        Бизнес Зал «{{ title }}»<span class="page-main__hall-code"
                    >Код Бизнес-зала: {{ hallPrefix }}</span
                    >
                    </p>
                </div>
                <dl class="amount-list">
                    <div class="amount-list__item">
                        <dt class="amount-list__term">Количество сертификатов</dt>
                        <dd class="amount-list__description">{{ totalCertificates }}</dd>
                    </div>
                    <div class="amount-list__item">
                        <dt class="amount-list__term">Количество посещений</dt>
                        <dd class="amount-list__description">{{ totalVisits }}</dd>
                    </div>
                </dl>
                <div class="page-main__flex-row">
                    <h2 class="page-main__title">Сертификаты</h2>
                    <ul class="buttons-list">
                        <li class="buttons-list__item">
                            <button  class="buttons-list__button" @click="downloadStatistics">
                                <SvgIcon name="download" width="16" height="16"/>
                                Сохранить
                            </button>
                        </li>
                        <li class="buttons-list__item">
                            <ShareNetwork network="email" class="buttons-list__button" >
                                <SvgIcon name="send" width="16" height="16"/>
                                Отправить
                            </ShareNetwork>
                        </li>
                        <li class="buttons-list__item">
                            <button class="buttons-list__button" disabled>
                                <SvgIcon name="xlsx" width="16" height="16"/>
                                Печатать (.xlsx)
                            </button>
                        </li>
                    </ul>
                </div>
                <Filters/>
                <CertificatesList/>
            </section>
        </div>
    </main>
</template>
<script>
import Filters from '../components/Filters.vue'
import CertificatesList from '../components/CertificatesList.vue'

export default {
    name: 'Certificates',
    components: {
        Filters,
        CertificatesList,
    },
    data() {
        return {
            filters: ''
        }
    },
    beforeMount() {
        this.$eventBus.$on('set-filters', this.setFilterHandler)
    },
    methods: {
        downloadStatistics() {
            this.$axios.get('/save-certificates' + this.filters, {
                responseType: 'blob'
            }).then((response)=>{
                const fileName = `gk-${this.hallPrefix.toLowerCase()}${this.$moment().format('DDMMYYYY')}.xlsx`
                const url = window.URL.createObjectURL(new Blob([response.data]))
                const link = document.createElement('a')

                link.href = url
                link.setAttribute('download', fileName);
                
                link.click()
            })
        },
        setFilterHandler({query}) {
            this.filters = query ? query : location.search
        },
        s2ab(s) {
            const buf = new ArrayBuffer(s.length)
            const view = new Uint8Array(buf)
            for (var i = 0; i < s.length; i++) view[i] = s.charCodeAt(i) & 0xFF
            return buf
        },
        toMain() {
            this.$router.push({name: 'Home'})
        },
    },
    computed: {
        certificates() {
            return this.$store.getters['getRegistryCertificates']
        },
        title() {
            return this.hallName ? this.hallName : this.hallAdminName
        },
        hallName() {
            return this.$store.getters['getRegistryName']
        },
        hallPrefix() {
            return this.$store.getters['getRegistryPrefix']
        },
        hallAdminName() {
            return this.$store.getters['getRegistryAdminName']
        },
        hallId() {
            return this.$store.getters['getRegistryId']
        },
        totalCertificates() {
            return this.$store.getters['getTotalCertificates']
        },
        totalVisits() {
            return this.$store.getters['getTotalVisits']
        },
    },
}
</script>
<style lang="scss" scoped>
    .buttons-list__button { //temp
        &:disabled {
            opacity: 0.5;
            pointer-events: none;
        }
    }
</style>
