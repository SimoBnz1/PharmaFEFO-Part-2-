<div class="space-y-8 animate-fade-in">
    <div class="bg-gradient-to-br from-white to-slate-50/50 p-6 rounded-3xl border border-slate-200/70 shadow-sm flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-black text-slate-900 tracking-tight">Surveillance Globale des Lots (API-Ready)</h2>
            <p class="text-xs text-slate-500 mt-1">Gestion asynchrone ultra-fluide via JavaScript fetch.</p>
        </div>

        <div class="flex gap-2 p-1.5 bg-slate-200/60 rounded-2xl border">
            <button onclick="loadDashboardLots('')" class="px-4 py-2 bg-white text-slate-900 rounded-xl text-xs font-black shadow-xs">Tous les lots</button>
            <button onclick="loadDashboardLots('critical')" class="px-4 py-2 text-rose-600 hover:bg-rose-50 rounded-xl text-xs font-black">Alerte Critique (&lt;30j)</button>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/30 border-b text-slate-400 text-[10px] font-black uppercase tracking-widest">
                        <th class="py-4 px-6">Désignation Produit</th>
                        <th class="py-4 px-4">Référence</th>
                        <th class="py-4 px-4">N° de Lot</th>
                        <th class="py-4 px-4">Quantité Physique</th>
                        <th class="py-4 px-4">DLU (Péremption)</th>
                        <th class="py-4 px-4">Indicateur Diagnostic</th>
                        <th class="py-4 px-6 text-right">Actions Restrictives</th>
                    </tr>
                </thead>
                <tbody id="api-stock-table-body" class="text-sm divide-y divide-slate-100">
                    <tr>
                        <td colspan="7" class="text-center py-8 text-slate-400 font-medium">Chargement des données en cours...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="/../PharmaFEFO-Part2/public/js/dashboard.js"></script>