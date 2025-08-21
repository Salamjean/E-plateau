@extends('doctor.layouts.template')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    :root {
        --primary: #009efb;
        --primary-light: #e6f5ff;
        --primary-dark: #0085d4;
        --white: #ffffff;
        --light-bg: #f8f9fa;
        --text-dark: #2c3e50;
        --text-light: #6c757d;
        --border: #e2e8f0;
        --card-shadow: 0 5px 15px rgba(0, 158, 251, 0.1);
        --transition: all 0.3s ease;
    }
    
    .dashboard-container {
        padding: 20px;
        background-color: var(--light-bg);
        min-height: calc(100vh - 76px);
    }
    
    .stat-card {
        background: var(--white);
        border-radius: 12px;
        color: var(--text-dark);
        box-shadow: var(--card-shadow);
        padding: 20px;
        margin-bottom: 20px;
        transition: var(--transition);
        height: 100%;
        position: relative;
        overflow: hidden;
        border-left: 4px solid var(--primary);
    }
    .stat-card1 {
        background: var(--white);
        border-radius: 12px;
        color: var(--text-dark);
        box-shadow: var(--card-shadow);
        padding: 20px;
        margin-bottom: 20px;
        transition: var(--transition);
        height: 100%;
        position: relative;
        overflow: hidden;
        border-left: 4px solid #f72585;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 158, 251, 0.15);
    }
    .stat-card1:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 158, 251, 0.15);
    }
    
    .stat-card i {
        position: absolute;
        right: 20px;
        top: 20px;
        font-size: 2.5rem;
        color: var(--primary);
        opacity: 0.2;
    }
    .stat-card1 i {
        position: absolute;
        right: 20px;
        top: 20px;
        font-size: 2.5rem;
        color:#f72585;
        opacity: 0.2;
    }
    
    .stat-card h6 {
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 5px;
        color: var(--text-light);
    }
    .stat-card1 h6 {
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 5px;
        color: var(--text-light);
    }
    .stat-card1 h6 {
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 5px;
        color: var(--text-light);
    }
    
    .stat-card .value {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0;
        color: var(--primary);
    }
    .stat-card1 .value {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0;
        color: #f72585;
    }
    
    .panel-modern {
        background: var(--white);
        border-radius: 12px;
        box-shadow: var(--card-shadow);
        margin-bottom: 25px;
        overflow: hidden;
        transition: var(--transition);
        border: 1px solid var(--border);
    }
    .panel-modern1 {
        background: var(--white);
        border-radius: 12px;
        box-shadow: var(--card-shadow);
        margin-bottom: 25px;
        overflow: hidden;
        transition: var(--transition);
        border: 1px solid var(--border);
    }
    
    .panel-modern:hover {
        box-shadow: 0 8px 20px rgba(0, 158, 251, 0.12);
    }
    .panel-modern1:hover {
        box-shadow: 0 8px 20px rgba(0, 158, 251, 0.12);
    }
    
    .panel-header {
        padding: 18px 25px;
        background: var(--white);
        border-bottom: 1px solid var(--border);
        font-weight: 600;
        font-size: 1.1rem;
        color: var(--primary);
        display: flex;
        align-items: center;
    }
    .panel-header1 {
        padding: 18px 25px;
        background: var(--white);
        border-bottom: 1px solid var(--border);
        font-weight: 600;
        font-size: 1.1rem;
        color: #f72585;
        display: flex;
        align-items: center;
    }
    
    .panel-header i {
        margin-right: 10px;
        color: var(--primary);
        background: var(--primary-light);
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .panel-header1 i {
        margin-right: 10px;
        color: #f72585;
        background: #f4edf0;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .panel-body {
        padding: 25px;
    }
    .panel-body1 {
        padding: 25px;
    }
    
    .declaration-item {
        background: var(--white);
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
        border: 1px solid var(--border);
        transition: var(--transition);
        position: relative;
    }
    
    .declaration-item:hover {
        border-color: var(--primary);
        box-shadow: 0 5px 15px rgba(0, 158, 251, 0.1);
    }
    
    .declaration-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 4px;
        background: var(--primary);
        border-radius: 4px 0 0 4px;
        opacity: 0;
        transition: var(--transition);
    }
    
    .declaration-item:hover::before {
        opacity: 1;
    }
    
    .declaration-item p {
        margin-bottom: 5px;
        font-size: 0.9rem;
    }
    
    .declaration-item .date {
        color: var(--text-light);
        font-size: 0.8rem;
        display: flex;
        align-items: center;
    }
    
    .declaration-item .date i {
        margin-right: 5px;
        font-size: 0.9rem;
        color: var(--primary);
    }
    .declaration-item1 {
        background: var(--white);
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
        border: 1px solid #f72585;
        transition: var(--transition);
        position: relative;
    }
    
    .declaration-item1:hover {
        border-color: #9e0248;
        box-shadow: 0 5px 15px rgba(0, 158, 251, 0.1);
    }
    
    .declaration-item1::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 4px;
        background: #f72585;
        border-radius: 4px 0 0 4px;
        opacity: 0;
        transition: var(--transition);
    }
    
    .declaration-item1:hover::before {
        opacity: 1;
    }
    
    .declaration-item1 p {
        margin-bottom: 5px;
        font-size: 0.9rem;
    }
    
    .declaration-item1 .date {
        color: var(--text-light);
        font-size: 0.8rem;
        display: flex;
        align-items: center;
    }
    
    .declaration-item1 .date i {
        margin-right: 5px;
        font-size: 0.9rem;
        color: #f72585;
    }
    
    .chart-container {
        background: var(--white);
        border-radius: 12px;
        padding: 25px;
        box-shadow: var(--card-shadow);
        margin-bottom: 25px;
        border: 1px solid var(--border);
    }
    
    .chart-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 20px;
        color: var(--primary);
        display: flex;
        align-items: center;
    }
    .chart-title1 {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 20px;
        color: #f72585;
        display: flex;
        align-items: center;
    }
    
    .chart-title i {
        margin-right: 10px;
        background: var(--primary-light);
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .chart-title1 i {
        margin-right: 10px;
        background-color: #f72585;
        color:white;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: var(--text-light);
    }
    
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 15px;
        color: var(--primary-light);
    }
    
    .empty-state p {
        margin-bottom: 0;
        font-size: 1rem;
    }
    
    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 25px;
        color: var(--text-dark);
        position: relative;
        padding-bottom: 10px;
    }
    
    .section-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 50px;
        height: 3px;
        background: var(--primary);
        border-radius: 3px;
    }
    
    @media (max-width: 768px) {
        .dashboard-container {
            padding: 15px;
        }
        
        .stat-card {
            margin-bottom: 15px;
            padding: 15px;
        }
        
        .panel-body {
            padding: 15px;
        }
        
        .chart-container {
            padding: 20px;
        }
    }
</style>

<div class="dashboard-container">
    <h2 class="section-title">Tableau de Bord</h2>
    
    <div class="row">
        <!-- Cartes de statistiques -->
        <div class="col-xl-4 col-md-6 col-sm-6 mb-4">
            <div class="stat-card">
                <i class="fas fa-baby"></i>
                <h6>NAISSANCES/JOUR</h6>
                <p class="value">{{ $naisshop }}</p>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 col-sm-6 mb-4">
            <div class="stat-card1">
                <i class="fas fa-cross"></i>
                <h6>DÉCÈS/JOUR</h6>
                <p class="value">{{ $deceshop }}</p>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 col-sm-6 mb-4">
            <div class="stat-card">
                <i class="fas fa-clipboard-list"></i>
                <h6>DÉCLARATIONS/JOUR</h6>
                <p class="value">{{ $total }}</p>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Déclarations de naissance récentes -->
        <div class="col-xl-6 col-md-12 mb-4">
            <div class="panel-modern">
                <div class="panel-header">
                    <i class="fas fa-baby-carriage"></i>
                    Déclaration de naissance récente
                </div>
                <div class="panel-body">
                    @if($declarationsRecents->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>Aucune déclaration récente</p>
                        </div>
                    @else
                        @foreach($declarationsRecents as $declaration)
                            <div class="declaration-item">
                                <p class="date">
                                    <i class="fas fa-calendar-alt"></i>
                                    {{ $declaration->created_at->format('d/m/Y à H:i') }}
                                </p>
                                <p><strong>Nom de la mère:</strong> {{ $declaration->NomM }} {{ $declaration->PrM }}</p>
                                <p><strong>Commune:</strong> {{ $declaration->commune }}</p>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <!-- Déclarations de décès récentes -->
        <div class="col-xl-6 col-md-12 mb-4">
            <div class="panel-modern1">
                <div class="panel-header1">
                    <i class="fas fa-cross"></i>
                    Déclaration de décès récente
                </div>
                <div class="panel-body1">
                    @if($decesRecents->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>Aucune déclaration récente</p>
                        </div>
                    @else
                        @foreach($decesRecents as $deces)
                            <div class="declaration-item1">
                                <p class="date">
                                    <i class="fas fa-calendar-alt"></i>
                                    {{ $deces->created_at->format('d/m/Y à H:i') }}
                                </p>
                                <p><strong>Nom du défunt:</strong> {{ $deces->NomM }} {{ $deces->PrM }}</p>
                                <p><strong>Commune:</strong> {{ $deces->commune }}</p>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="chart-container">
                <div class="chart-title">
                    <i class="fas fa-chart-bar"></i>
                    Naissances par mois
                </div>
                <canvas id="naissChart"></canvas>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="chart-container">
                <div class="chart-title1">
                    <i class="fas fa-chart-line"></i>
                    Décès par mois
                </div>
                <canvas id="decesChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    const naissData = @json(array_values($naissData)); 
    const decesData = @json(array_values($decesData)); 
    const months = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];
    
    // Configuration des graphiques
    const chartOptions = {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.7)',
                titleFont: {
                    family: 'Poppins, sans-serif'
                },
                bodyFont: {
                    family: 'Poppins, sans-serif'
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    drawBorder: false,
                    color: 'rgba(0, 0, 0, 0.05)'
                },
                ticks: {
                    font: {
                        family: 'Poppins, sans-serif'
                    }
                }
            },
            x: {
                grid: {
                    display: false
                },
                ticks: {
                    font: {
                        family: 'Poppins, sans-serif'
                    }
                }
            }
        }
    };
    
    // Graphique des naissances
    const naissCtx = document.getElementById('naissChart').getContext('2d');
    const naissChart = new Chart(naissCtx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Naissances',
                data: naissData,
                backgroundColor: '#009efb',
                borderColor: '#0085d4',
                borderWidth: 1,
                borderRadius: 6,
                hoverBackgroundColor: '#0085d4'
            }]
        },
        options: chartOptions
    });
    
    // Graphique des décès
    const decesCtx = document.getElementById('decesChart').getContext('2d');
    const decesChart = new Chart(decesCtx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Décès',
                data: decesData,
                backgroundColor: '#f72585',
                borderColor: '#f72585',
                borderWidth: 1,
                borderRadius: 6,
                hoverBackgroundColor: '#4ca8e8'
            }]
        },
        options: chartOptions
    });
</script>
@endsection