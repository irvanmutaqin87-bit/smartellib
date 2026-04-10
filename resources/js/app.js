import { initNavbar } from "./navbar";
import { initDropdown } from "./dropdown";
import { initCarousel } from "./carousel";
import { initLoadMore } from "./books";
import { initTabs } from "./tabs";
import { initBookAnimation } from "./animations";
import { initFilter } from "./filter";
import { initDescriptionToggle } from "./description";
import { initAdminDropdown } from "./adminDropdown";
import { initDendaModal } from "./dendaModal";
import { initPasswordModal } from "./passwordModal";
import { initRating } from "./rating";

import { initToast } from "./toast";
import { initPasswordToggle } from "./passwordToggle";
import { initFormLoading } from "./formLoading";
import { initRevealAnimation } from "./revealAnimation";
import { initBookActionsModal } from "./bookActionsModal";
import { initSearch } from "./search";
import { initSearchNavbar } from "./searchNavbar";
import { initSidebarActive } from "./sidebar-active";
import { initShare } from "./share";

import { initAnggotaToast } from "./anggotaToast";
import {
    initAjaxTable,
    initRealtimeKategoriDropdown,
    initCustomAjaxFilterDropdown,
} from "./ajaxTable";
import { initAjaxAction, initAjaxForm } from "./ajaxAction";
import { initAjaxSimpleAction } from "./ajaxSimpleAction";
import { initPetugasDenda } from "./petugas-denda";
import { initLaporanPage } from "./laporan";
import { initDashboardChart } from "./dashboardChart";
import { initChartFilter } from "./dashboardChart";

document.addEventListener("DOMContentLoaded", () => {
    initNavbar();
    initDropdown();
    initCarousel();
    initTabs();
    initLoadMore();
    initBookAnimation();
    initFilter();
    initDescriptionToggle();
    initAdminDropdown();
    initPasswordModal();

    initToast();
    initPasswordToggle();
    initFormLoading();
    initRevealAnimation();
    initBookActionsModal();
    initSearch();
    initSearchNavbar();
    initDendaModal();
    initSidebarActive();
    initAnggotaToast();
    initRating();

    initAjaxSimpleAction();
    initPetugasDenda();

    initLaporanPage();
    initChartFilter();

    initShare();

    // =========================
    // AJAX TABLE ANGGOTA
    // =========================
    if (
        document.querySelector("#tableContainer") &&
        window.location.pathname.includes("/petugas/anggota")
    ) {
        initAjaxTable({
            url: "/petugas/anggota?page=1",
            tableContainer: "#tableContainer",
            paginationContainer: "#paginationContainer",
            searchInput: "#searchInput",
            filterInputs: ["#statusFilter"],
            autoRefresh: true,
            refreshInterval: 3000,
        });
    }

    // =========================
    // AJAX TABLE KATEGORI (INDEX)
    // =========================
    if (
        document.querySelector("#tableContainer") &&
        window.location.pathname === "/admin/kategori"
    ) {
        initAjaxTable({
            url: "/admin/kategori?page=1",
            tableContainer: "#tableContainer",
            paginationContainer: "#paginationContainer",
            searchInput: "#searchInput",
            filterInput: null,
            autoRefresh: true,
            refreshInterval: 3000,
            extraTargets: {
                totalBox: "#totalKategoriBox",
            },
        });
    }

    // =========================
    // AJAX TABLE BUKU PETUGAS
    // =========================
    if (
        document.querySelector("#tableContainer") &&
        window.location.pathname === "/petugas/buku"
    ) {
        initAjaxTable({
            url: "/petugas/buku",
            tableContainer: "#tableContainer",
            paginationContainer: "#paginationContainer",
            searchInput: "#searchInput",
            filterInputs: ["#statusFilter", "#kategoriFilter"],
            autoRefresh: true,
            refreshInterval: 10000, // 10 detik
            extraTargets: {
                totalBox: "#totalBukuBox",
            },
        });
    }

    // =========================
    // AJAX TABLE BUKU ADMIN
    // =========================
    if (
        document.querySelector("#tableContainer") &&
        window.location.pathname === "/admin/buku"
    ) {
        initAjaxTable({
            url: "/admin/buku",
            tableContainer: "#tableContainer",
            paginationContainer: "#paginationContainer",
            searchInput: "#searchInput",
            filterInputs: ["#statusFilter", "#kategoriFilter"],
            autoRefresh: true,
            refreshInterval: 10000, // 10 detik
            extraTargets: {
                totalBox: "#totalBukuBox",
            },
        });
    }

    // =========================
    // AJAX TABLE ANGGOTA ADMIN
    // =========================
    if (
        document.querySelector("#tableContainer") &&
        window.location.pathname.includes("/admin/anggota")
    ) {
        initAjaxTable({
            url: "/admin/anggota?page=1",
            tableContainer: "#tableContainer",
            paginationContainer: "#paginationContainer",
            searchInput: "#searchInput",
            filterInputs: ["#statusFilter"],
            autoRefresh: true,
            refreshInterval: 5000,
        });
    }

    // =========================
    // AJAX TABLE PEMINJAMAN PETUGAS
    // =========================
    if (
        document.querySelector("#tableContainer") &&
        window.location.pathname === "/petugas/peminjaman"
    ) {
        initAjaxTable({
            url: "/petugas/peminjaman",
            tableContainer: "#tableContainer",
            paginationContainer: "#paginationContainer",
            searchInput: "#searchInput",
            filterInputs: ["#statusFilter"],
            autoRefresh: true,
            refreshInterval: 8000,
            extraTargets: {
                totalBox: "#totalPeminjamanBox",
            },
        });
    }

    // =========================
    // AJAX TABLE ANTRIAN PEMINJAMAN PETUGAS
    // =========================
    if (
        document.querySelector("#tableContainer") &&
        window.location.pathname === "/petugas/antrian-peminjaman"
    ) {
        initAjaxTable({
            url: "/petugas/antrian-peminjaman",
            tableContainer: "#tableContainer",
            paginationContainer: "#paginationContainer",
            searchInput: "#searchInput",
            filterInputs: ["#statusFilter"],
            autoRefresh: true,
            refreshInterval: 8000,
            extraTargets: {
                totalBox: "#totalAntrianBox",
            },
        });
    }

    // =========================
    // AJAX TABLE DENDA PETUGAS
    // =========================
    if (
        document.querySelector("#tableContainer") &&
        window.location.pathname === "/petugas/denda"
    ) {
        initAjaxTable({
            url: "/petugas/denda",
            tableContainer: "#tableContainer",
            paginationContainer: "#paginationContainer",
            searchInput: "#searchInput",
            filterInputs: ["#statusFilter"],
            autoRefresh: true,
            refreshInterval: 8000,
            extraTargets: {
                totalBox: "#totalDendaBox",
            },
        });
    }

    // =========================
    // AJAX TABLE PETUGAS ADMIN
    // =========================
    if (
        document.querySelector("#tableContainer") &&
        window.location.pathname.includes("/admin/petugas")
    ) {
        initAjaxTable({
            url: "/admin/petugas?page=1",
            tableContainer: "#tableContainer",
            paginationContainer: "#paginationContainer",
            searchInput: "#searchInput",
            filterInputs: ["#statusFilter"],
            autoRefresh: true,
            refreshInterval: 5000,
        });
    }

    // =========================
    // CUSTOM DROPDOWN STATUS FILTER
    // =========================
    initCustomAjaxFilterDropdown({
        buttonId: "statusFilterBtn",
        dropdownId: "statusFilterDropdown",
        textId: "statusFilterText",
        inputId: "statusFilter",
        optionClass: "statusOption",
        defaultText: "Semua Status",
        useDataValue: true,
    });

    // =========================
    // CUSTOM DROPDOWN METODE PEMBAYARAN DENDA
    // KHUSUS HALAMAN PENGATURAN SISTEM
    // =========================
    initCustomAjaxFilterDropdown({
        buttonId: "metodePembayaranBtn",
        dropdownId: "metodePembayaranDropdown",
        textId: "metodePembayaranText",
        inputId: "metodePembayaranInput",
        optionClass: "metodePembayaranOption",
        defaultText: "Pilih Metode Pembayaran",
        useDataValue: true,
    });

    // =========================
    // AJAX TABLE LAPORAN ADMIN
    // =========================
    if (
        document.querySelector("#tableContainer") &&
        window.location.pathname === "/admin/laporan"
    ) {
        initAjaxTable({
            url: "/admin/laporan/data?jenis_laporan=peminjaman",
            tableContainer: "#tableContainer",
            paginationContainer: "#paginationContainer",
            searchInput: "#searchInput",
            filterInputs: [
                "#jenisLaporanFilter",
                "#periodeFilter",
                "#statusFilter",
                "#tanggalDariFilter",
                "#tanggalSampaiFilter",
                "#bulanFilter",
                "#tahunFilter",
            ],
            autoRefresh: false,
            extraTargets: {
                totalBox: "#totalLaporanBox",
            },
        });
    }

    // =========================
    // AJAX TABLE DASHBOARD ADMIN
    // =========================
    if (
        document.querySelector("#tableContainer") &&
        window.location.pathname === "/admin/dashboard"
    ) {
        initAjaxTable({
            url: "/admin/dashboard",
            tableContainer: "#tableContainer",
            paginationContainer: "#paginationContainer",
            searchInput: "#searchInput",
            filterInputs: ["#statusFilter"],
            autoRefresh: true,
            refreshInterval: 10000,
        });
    }

    // =========================
    // CUSTOM DROPDOWN JENIS LAPORAN
    // =========================
    initCustomAjaxFilterDropdown({
        buttonId: "jenisLaporanBtn",
        dropdownId: "jenisLaporanDropdown",
        textId: "jenisLaporanText",
        inputId: "jenisLaporanFilter",
        optionClass: "jenisLaporanOption",
        defaultText: "Laporan Peminjaman",
        useDataValue: true,
    });

    // =========================
    // CUSTOM DROPDOWN PERIODE LAPORAN
    // =========================
    initCustomAjaxFilterDropdown({
        buttonId: "periodeFilterBtn",
        dropdownId: "periodeFilterDropdown",
        textId: "periodeFilterText",
        inputId: "periodeFilter",
        optionClass: "periodeOption",
        defaultText: "Semua Periode",
        useDataValue: true,
    });

    // =========================
    // CUSTOM DROPDOWN BULAN LAPORAN
    // =========================
    initCustomAjaxFilterDropdown({
        buttonId: "bulanFilterBtn",
        dropdownId: "bulanFilterDropdown",
        textId: "bulanFilterText",
        inputId: "bulanFilter",
        optionClass: "bulanOption",
        defaultText: "Semua Bulan",
        useDataValue: true,
    });

    // =========================
    // CUSTOM DROPDOWN TAHUN LAPORAN
    // =========================
    initCustomAjaxFilterDropdown({
        buttonId: "tahunFilterBtn",
        dropdownId: "tahunFilterDropdown",
        textId: "tahunFilterText",
        inputId: "tahunFilter",
        optionClass: "tahunOption",
        defaultText: "Semua Tahun",
        useDataValue: true,
    });

    // =========================
    // AJAX ACTION (hapus / status / dll)
    // =========================
    initAjaxAction();

    // =========================
    // AJAX FORM KATEGORI (CREATE / EDIT)
    // =========================
    if (document.querySelector("#kategoriForm")) {
        initAjaxForm("#kategoriForm");
        console.log("AJAX FORM kategori aktif");
    }

    // =========================
    // AJAX FORM BUKU (CREATE)
    // =========================
    if (document.querySelector("#bukuForm")) {
        initAjaxForm("#bukuForm");
        console.log("AJAX FORM buku aktif");
    }

    // =========================
    // AJAX FORM PENGATURAN SISTEM
    // =========================
    if (document.querySelector("#pengaturanForm")) {
        initAjaxForm("#pengaturanForm");
        console.log("AJAX FORM pengaturan sistem aktif");
    }

    // =========================
    // REALTIME DROPDOWN KATEGORI
    // =========================
    console.log("MEMANGGIL REALTIME KATEGORI");
    initRealtimeKategoriDropdown();

    // =========================
    // AJAX FORM PEMINJAMAN
    // =========================
    if (document.querySelector("#peminjamanForm")) {
        initAjaxForm("#peminjamanForm");
        console.log("AJAX FORM peminjaman aktif");
    }

    // =========================
    // AJAX FORM PETUGAS (CREATE / EDIT)
    // =========================
    if (document.querySelector("#petugasForm")) {
        initAjaxForm("#petugasForm");
        console.log("AJAX FORM petugas aktif");
    }

    // =========================
    // AJAX FORM UPLOAD DENDA
    // =========================
    if (document.querySelector("#uploadDendaForm")) {
        initAjaxForm("#uploadDendaForm");
        console.log("AJAX FORM upload denda aktif");
    }

    // =========================
    // DASHBOARD CHART
    // =========================
    if (document.getElementById("peminjamanChart")) {
        initDashboardChart(window.chartLabels, window.chartData);
    }
});
