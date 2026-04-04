// =========================
// 🔹 AJAX ACTION (TOMBOL: hapus, status, dll)
// =========================
export function initAjaxAction() {
    document.addEventListener("click", async function (e) {
        const btn = e.target.closest(".ajaxAction");
        if (!btn) return;

        e.preventDefault();

        const url = btn.dataset.url;
        const method = btn.dataset.method || "POST";
        const confirmText = btn.dataset.confirm;
        const shouldReload = btn.dataset.reload !== "false";

        if (!url) {
            showToast("URL action tidak ditemukan", true);
            return;
        }

        // =========================
        // ⚠️ CONFIRM
        // =========================
        if (confirmText) {
            const ok = confirm(confirmText);
            if (!ok) return;
        }

        // =========================
        // 🔒 DISABLE BUTTON
        // =========================
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = "Processing...";

        try {
            const res = await fetch(url, {
                method: method,
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute("content"),
                    "X-Requested-With": "XMLHttpRequest",
                    Accept: "application/json",
                },
            });

            const data = await safeJson(res);

            if (!res.ok) {
                throw data;
            }

            if (shouldReload && window.reloadAjaxTable) {
                window.reloadAjaxTable();
            }

            //  trigger global kalau kategori berubah
            if (url.includes("/kategori")) {
                const waktuUpdate = Date.now().toString();
                localStorage.setItem("kategori_updated_at", waktuUpdate);
                console.log("KATEGORI UPDATED VIA ACTION:", waktuUpdate);
            }

            const nextStatus = btn.dataset.next;
            if (nextStatus) {
                updateDetailUI(nextStatus, btn);
            }

            showToast(data.message || "Berhasil");
        } catch (err) {
            console.error("AJAX ERROR:", err);
            showToast(err.message || "Terjadi kesalahan", true);
        } finally {
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    });
}

// =========================
// 🔄 UPDATE UI DETAIL PAGE
// NOTE: khusus halaman detail anggota
// Kalau halaman lain tidak punya statusBadge,
// function ini akan otomatis tidak berpengaruh
// =========================
function updateDetailUI(status, btn) {
    const badge = document.getElementById("statusBadge");
    const actionContainer =
        document.getElementById("detailActionContainer") ||
        btn.closest(".flex");

    if (badge) {
        if (status === "aktif") {
            badge.innerHTML = `
                <span class="px-3 py-1 text-xs rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100">
                    Aktif
                </span>
            `;
        } else if (status === "pending") {
            badge.innerHTML = `
                <span class="px-3 py-1 text-xs rounded-full bg-yellow-50 text-yellow-600 border border-yellow-100">
                    Pending
                </span>
            `;
        } else {
            badge.innerHTML = `
                <span class="px-3 py-1 text-xs rounded-full bg-slate-100 text-slate-600 border border-slate-200">
                    Nonaktif
                </span>
            `;
        }
    }

    if (actionContainer) {
        const userId = getIdFromUrl(btn.dataset.url);
        const currentUrl = btn.dataset.url || "";

        let newButton = "";

        // =========================
        // KHUSUS DETAIL PETUGAS ADMIN
        // =========================
        if (
            currentUrl.includes("/admin/petugas/") &&
            currentUrl.includes("/toggle-status")
        ) {
            if (status === "aktif") {
                newButton = `
                    <button 
                        id="togglePetugasStatusBtn"
                        class="ajaxAction actionBtn px-5 py-2 rounded-xl bg-red-500 text-white text-sm"
                        data-url="/admin/petugas/${userId}/toggle-status"
                        data-method="PATCH"
                        data-confirm="Nonaktifkan petugas ini?"
                        data-next="nonaktif"
                    >
                        Nonaktifkan Petugas
                    </button>
                `;
            } else if (status === "nonaktif") {
                newButton = `
                    <button 
                        id="togglePetugasStatusBtn"
                        class="ajaxAction actionBtn px-5 py-2 rounded-xl bg-blue-500 text-white text-sm"
                        data-url="/admin/petugas/${userId}/toggle-status"
                        data-method="PATCH"
                        data-confirm="Aktifkan kembali petugas ini?"
                        data-next="aktif"
                    >
                        Aktifkan Petugas
                    </button>
                `;
            }
        }

        // =========================
        // KHUSUS DETAIL ANGGOTA
        // =========================
        else if (currentUrl.includes("/petugas/anggota/")) {
            if (status === "aktif") {
                newButton = `
                    <button 
                        class="ajaxAction actionBtn px-5 py-2 rounded-xl bg-red-500 text-white text-sm"
                        data-url="/petugas/anggota/${userId}/nonaktifkan"
                        data-confirm="Nonaktifkan anggota ini?"
                        data-next="nonaktif"
                    >
                        Nonaktifkan Anggota
                    </button>
                `;
            } else if (status === "nonaktif") {
                newButton = `
                    <button 
                        class="ajaxAction actionBtn px-5 py-2 rounded-xl bg-blue-500 text-white text-sm"
                        data-url="/petugas/anggota/${userId}/aktifkan"
                        data-confirm="Aktifkan kembali anggota ini?"
                        data-next="aktif"
                    >
                        Aktifkan Anggota
                    </button>
                `;
            }
        }

        if (newButton) {
            actionContainer.innerHTML = newButton;
        }
    }
}

// =========================
// 🔧 HELPER AMBIL ID
// =========================
function getIdFromUrl(url) {
    const parts = url.split("/");
    return parts[parts.length - 2];
}

// =========================
// 🔹 AJAX FORM (CREATE / EDIT UNIVERSAL)
// =========================
export function initAjaxForm(selector) {
    const forms = document.querySelectorAll(selector);

    forms.forEach((form) => {
        // =========================
        // REALTIME CLEAR ERROR
        // =========================
        form.querySelectorAll("input, textarea, select").forEach((field) => {
            field.addEventListener("input", () =>
                clearFieldError(form, field.name),
            );
            field.addEventListener("change", () =>
                clearFieldError(form, field.name),
            );
        });

        // =========================
        // RESET BUTTON CUSTOM
        // =========================
        form.addEventListener("reset", () => {
            setTimeout(() => {
                clearAllErrors(form);
                resetPreviewUI(form);
            }, 50);
        });

        // =========================
        // PREVIEW COVER
        // =========================
        const coverInput = form.querySelector("#coverInput");
        const coverPreview = form.querySelector("#coverPreview");
        const coverPlaceholder = form.querySelector("#coverPlaceholder");

        if (coverInput && coverPreview) {
            coverInput.addEventListener("change", function () {
                const file = this.files[0];

                if (file) {
                    coverPreview.src = URL.createObjectURL(file);
                    coverPreview.classList.remove("hidden");
                    coverPlaceholder?.classList.add("hidden");
                } else {
                    coverPreview.src = "";
                    coverPreview.classList.add("hidden");
                    coverPlaceholder?.classList.remove("hidden");
                }
            });
        }

        // =========================
        // PREVIEW PDF NAME
        // =========================
        const pdfInput = form.querySelector("#pdfInput");
        const pdfFileName = form.querySelector("#pdfFileName");
        const pdfFileText = form.querySelector("#pdfFileText");

        if (pdfInput) {
            pdfInput.addEventListener("change", function () {
                const file = this.files[0];

                if (file) {
                    if (pdfFileName) pdfFileName.textContent = file.name;
                    if (pdfFileText) pdfFileText.textContent = "Ganti File PDF";
                } else {
                    if (pdfFileName) {
                        pdfFileName.textContent = "Belum ada file dipilih";
                    }
                    if (pdfFileText) {
                        pdfFileText.textContent = "Pilih File PDF";
                    }
                }
            });
        }

        // =========================
        // SUBMIT AJAX
        // =========================
        form.addEventListener("submit", async function (e) {
            e.preventDefault();

            clearAllErrors(form);

            const submitBtn = form.querySelector("button[type='submit']");
            const originalText = submitBtn?.innerHTML || "Simpan";

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = "Processing...";
            }

            const formData = new FormData(form);
            const url = form.action;
            const method = form.method.toUpperCase();

            try {
                const res = await fetch(url, {
                    method: method,
                    headers: {
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            ?.getAttribute("content"),
                        "X-Requested-With": "XMLHttpRequest",
                        Accept: "application/json",
                    },
                    body: formData,
                });

                const data = await safeJson(res);

                if (!res.ok) {
                    if (res.status === 413) {
                        throw {
                            message:
                                "Ukuran file terlalu besar. Maksimal upload server saat ini belum cukup.",
                        };
                    }

                    throw data;
                }

                showToast(data.message || "Data berhasil disimpan");
                document.dispatchEvent(
                    new CustomEvent("ajaxFormSuccess", {
                        detail: {
                            formId: form.id,
                        },
                    }),
                );

                if (window.reloadAjaxTable) {
                    window.reloadAjaxTable();
                }

                // =========================
                // 🔔 TRIGGER KATEGORI BERUBAH
                // =========================
                if (form.id === "kategoriForm") {
                    const waktuUpdate = Date.now().toString();

                    localStorage.setItem("kategori_updated_at", waktuUpdate);

                    console.log("KATEGORI UPDATED (ADMIN):", waktuUpdate);
                }

                // =========================
                // RESET FORM HANYA JIKA DIIZINKAN
                // create  -> true
                // edit    -> false
                // =========================
                const shouldReset = form.dataset.resetOnSuccess === "true";

                if (shouldReset) {
                    form.reset();
                    clearAllErrors(form);
                    resetPreviewUI(form);
                }
            } catch (err) {
                console.error("AJAX FORM ERROR:", err);

                if (err.errors) {
                    showValidationErrors(form, err.errors);

                    const firstError = Object.values(err.errors)[0]?.[0];
                    showToast(firstError || "Validasi gagal", true);
                } else if (err.message) {
                    showToast(err.message, true);
                } else {
                    showToast("Terjadi kesalahan saat upload data", true);
                }
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
            }
        });
    });
}

// =========================
// 🔴 TAMPILKAN ERROR VALIDASI
// =========================
function showValidationErrors(form, errors) {
    Object.keys(errors).forEach((fieldName) => {
        const input = form.querySelector(`[name="${fieldName}"]`);
        const errorEl = form.querySelector(
            `.error-message[data-field="${fieldName}"]`,
        );

        if (input) {
            input.classList.add("border-red-500", "ring-1", "ring-red-200");
            input.classList.remove("border-slate-200");
        }

        if (errorEl) {
            errorEl.textContent = errors[fieldName][0];
        }
    });
}

// =========================
// 🧹 CLEAR 1 FIELD ERROR
// =========================
function clearFieldError(form, fieldName) {
    const input = form.querySelector(`[name="${fieldName}"]`);
    const errorEl = form.querySelector(
        `.error-message[data-field="${fieldName}"]`,
    );

    if (input) {
        input.classList.remove("border-red-500", "ring-1", "ring-red-200");
        input.classList.add("border-slate-200");
    }

    if (errorEl) {
        errorEl.textContent = "";
    }
}

// =========================
// 🧼 CLEAR SEMUA ERROR
// =========================
function clearAllErrors(form) {
    form.querySelectorAll(".error-message").forEach((el) => {
        el.textContent = "";
    });

    form.querySelectorAll("input, textarea, select").forEach((input) => {
        input.classList.remove("border-red-500", "ring-1", "ring-red-200");
        input.classList.add("border-slate-200");
    });
}

// =========================
// 🖼️ RESET PREVIEW UI
// Khusus form yang sedang aktif
// =========================
function resetPreviewUI(form) {
    const coverPreview = form.querySelector("#coverPreview");
    const coverPlaceholder = form.querySelector("#coverPlaceholder");
    const pdfFileName = form.querySelector("#pdfFileName");
    const pdfFileText = form.querySelector("#pdfFileText");

    if (coverPreview) {
        coverPreview.src = "";
        coverPreview.classList.add("hidden");
    }

    if (coverPlaceholder) {
        coverPlaceholder.classList.remove("hidden");
    }

    if (pdfFileName) {
        pdfFileName.textContent = "Belum ada file dipilih";
    }

    if (pdfFileText) {
        pdfFileText.textContent = "Pilih File PDF";
    }
}

// =========================
// 🛡️ SAFE JSON PARSER
// Biar tidak error kalau response bukan JSON
// =========================
async function safeJson(res) {
    const contentType = res.headers.get("content-type") || "";
    const text = await res.text();

    if (contentType.includes("application/json")) {
        try {
            return JSON.parse(text);
        } catch (e) {
            return {
                message: "Response JSON tidak valid",
                raw: text,
            };
        }
    }

    // Tangani error HTML / Apache / PHP
    if (res.status === 413) {
        return {
            message:
                "Ukuran file terlalu besar untuk server. Cek batas upload PHP / Apache.",
            raw: text,
        };
    }

    return {
        message: "Server mengembalikan response non-JSON",
        raw: text,
    };
}

// =========================
// 🔔 TOAST UNIVERSAL
// =========================
function showToast(message, isError = false) {
    const container = document.getElementById("toastContainer");
    if (!container) return;

    const toast = document.createElement("div");

    toast.className = `
        bg-white/80 backdrop-blur-md text-slate-700
        px-6 py-3 rounded-xl shadow-lg text-sm font-medium
        transform scale-75 opacity-0
        transition-all duration-500 ease-out
        border border-slate-200
    `;

    if (isError) {
        toast.classList.remove(
            "bg-white/80",
            "text-slate-700",
            "border-slate-200",
        );
        toast.classList.add("bg-red-500", "text-white", "border-red-500");
    }

    toast.innerText = message;
    container.appendChild(toast);

    setTimeout(() => {
        toast.classList.remove("scale-75", "opacity-0");
        toast.classList.add("scale-100", "opacity-100");
    }, 50);

    setTimeout(() => {
        toast.classList.add("opacity-0", "-translate-y-2");
    }, 2200);

    setTimeout(() => {
        toast.remove();
    }, 2700);
}
