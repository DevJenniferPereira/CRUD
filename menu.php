{% macro barra_navegacao() %}
    {% from 'bootstrap5/nav.html' import render_nav_item %}
    {% from 'bootstrap5/utils.html' import render_icon %}
    <nav class="navbar navbar-expand-sm bg-primary-subtle rounded-4 shadow-sm mb-3 px-3 py-2 sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand ps-3" href="{{ url_for('index') }}">{{ render_icon('shop', size=60) }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown">
                            {{ render_icon('box-seam') }} Produtos
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg-end">
                            <li><a class="dropdown-item" href="#">{{ render_icon('card-list') }}&nbsp;Listar</a></li>
                            <li><a class="dropdown-item" href="#">{{ render_icon('plus') }}&nbsp;Adicionar</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">{{ render_icon('exclamation-diamond') }}&nbsp;Produtos em falta</a></li>
                            <li><a class="dropdown-item" href="#">{{ render_icon('boxes') }}&nbsp;Estoque</a></li>
                            <li><a class="dropdown-item" href="#">{{ render_icon('cart') }}&nbsp;Comprar/vender em lote</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown">
                            {{ render_icon('book') }} Categorias
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg-end">
                            <li><a class="dropdown-item" href="#">{{ render_icon('card-list') }}&nbsp;Listar</a></li>
                            <li><a class="dropdown-item" href="#">{{ render_icon('plus') }}&nbsp;Adicionar</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown ms-3">
                        <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown">
                            <span class="fw-semibold">Acesso ao sistema</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg-end">
                            <li><a class="dropdown-item" href="#">{{ render_icon('box-arrow-in-right') }}&nbsp;Login</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">{{ render_icon('person') }}&nbsp;Perfil</a></li>
                            <li><a class="dropdown-item" href="#">{{ render_icon('toggles') }}&nbsp;Gerenciamento dos usuários</a></li>
                            <li><a class="dropdown-item" href="#">{{ render_icon('person-plus') }}&nbsp;Criar conta</a></li>
                            <li><a class="dropdown-item" href="#">{{ render_icon('box-arrow-right') }}&nbsp;Logout</a>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
{% endmacro %}

<?php
require_once "rodape.php";
?>