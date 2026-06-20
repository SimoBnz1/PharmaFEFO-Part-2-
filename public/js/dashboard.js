// public/js/dashboard.js

document.addEventListener('DOMContentLoaded', () => {
    loadDashboardLots();
});


function loadDashboardLots(filter = '') {
    const tbody = document.getElementById('api-stock-table-body');
    if (!tbody) return; 

   
    let url = '/PharmaFEFO-Part2/public/index.php?action=api-lots';
    if (filter) url += `&filter=${filter}`;

    tbody.innerHTML = `<tr><td colspan="7" class="text-center py-8 text-slate-400">Chargement des données...</td></tr>`;

    fetch(url)
        .then(response => {
            if (!response.ok) throw new Error("HTTP error " + response.status);
            return response.json();
        })
        .then(lots => {
            tbody.innerHTML = ''; 

            if (!lots || lots.length === 0) {
                tbody.innerHTML = `<tr><td colspan="7" class="text-center py-8 text-slate-400">Aucun lot disponible.</td></tr>`;
                return;
            }

            lots.forEach(lot => {
                const tr = document.createElement('tr');
                tr.id = `lot-row-${lot.id}`;
                tr.className = "hover:bg-slate-50/50 transition-colors";
                
                tr.innerHTML = `
                    <td class="py-4 px-6 font-bold text-slate-900">${lot.nom}</td>
                    <td class="py-4 px-4 text-slate-500 font-mono text-xs">${lot.reference}</td>
                    <td class="py-4 px-4 text-slate-700 font-semibold">${lot.numero_lot}</td>
                    <td class="py-4 px-4 font-black text-slate-900 qty-field">${lot.quantite} boîtes</td>
                    <td class="py-4 px-4 font-mono text-xs text-slate-600">${lot.date_peremption}</td>
                    <td class="py-4 px-4">
                        <span class="px-2.5 py-1 rounded-full text-[11px] font-bold ${lot.color_classes}">
                            ${lot.badge_text}
                        </span>
                    </td>
                    <td class="py-4 px-6 text-right">
                        <button onclick="dispenseBox(${lot.id})" 
                                class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold py-1.5 px-3 rounded-lg transition-all dispense-btn"
                                ${lot.quantite <= 0 ? 'disabled style="opacity:0.5;"' : ''}>
                            Délivrer 1 bte
                        </button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        })
        .catch(error => {
            console.error("Fetch Error:", error);
            tbody.innerHTML = `<tr><td colspan="7" class="text-center py-8 text-rose-600 font-bold">Erreur de chargement des données.</td></tr>`;
        });
}


function dispenseBox(lotId) {
    const row = document.getElementById(`lot-row-${lotId}`);
    const qtyField = row.querySelector('.qty-field');
    const button = row.querySelector('.dispense-btn');

    fetch('/PharmaFEFO-Part2/public/index.php?action=api-dispense', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: lotId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            qtyField.textContent = `${data.new_qty} boîtes`;
            if (data.new_qty <= 0) {
                row.style.opacity = '0.4';
                button.disabled = true;
                button.textContent = "Épuisé";
            }
        } else {
            alert(data.message || "Erreur lors de l'opération");
        }
    })
    .catch(error => alert("Erreur de connexion avec le serveur"));
}

document.getElementById("FormAddBatch")?.addEventListener("submit",function (e) {
    e.preventDefault();

    let data={
        produit_id: document.getElementById('produit_id').value,
        numero_lot: document.getElementById('numero_lot').value,
        quantite: document.getElementById('quantite').value,
        date_peremption: document.getElementById('date_peremption').value
    };

    console.log(data);
    fetch('/PharmaFEFO-Part2/public/index.php?action=add-batch',{
        method:'POST',
        headers:{
            'Content-Type' : 'application/jason'
        },
        body:JSON.stringify(data)
    })
    .then(res=>res.json)
    .then(res=>
        alert('ajouter avec succes ')
    )
        

    
    
})