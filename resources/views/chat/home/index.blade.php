@extends('layouts.chat')

@section('content')
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <!-- Left Column - Info -->
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="pe-lg-5 fade-in">
                        <h1 class="display-6 fw-bold mb-4 mt-5">
                            Encontre o advogado ideal para seu caso
                        </h1>
                        <p class="lead text-muted mb-4">
                            Conectamos você com advogados especializados em sua área de necessidade.
                            Rápido, seguro e confiável.
                        </p>

                        <!-- Features -->
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <i class="fas fa-shield-alt"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-bold">SUAS INFORMAÇÕES ESTÃO SEGURAS</h6>
                                        <small class="text-muted">Protegemos seus dados com criptografia de ponta</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-bold">RESPOSTAS EM POUCOS MINUTOS</h6>
                                        <small class="text-muted">Advogados qualificados respondem rapidamente</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Lawyer Card -->
                <div class="col-lg-6">
                    <div class="lawyer-card pulse">
                        <img src="{{ asset('assets/img/dr-nuvun.png') }}"
                             alt="Advogado especialista"
                             class="lawyer-avatar"
                             loading="lazy"
                        />

                        <div class="lawyer-message">
                            <div class="d-flex align-items-start gap-3">
                                <div class="text-start">
                                    <p class="mb-0">
                                        <strong>Sou Dr. Nuvun</strong> e vou te ajudar.
                                        <strong>Me conta sobre o seu caso!</strong>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="position-relative">

                            <livewire:chat.messages />

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


