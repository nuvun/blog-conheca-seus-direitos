<!-- Botão flutuante de Consulta Jurídica -->
<a href="{{ route('chat.home.index') }}"
   class="floating-consult-btn"
   title="Consulta Jurídica com IA"
   target="_blank"
>
    <i class="fa-solid fa-robot"></i>
    <div class="floating-consult-tooltip">
        Consulta Jurídica
    </div>
</a>

<style>
        .floating-consult-btn {
            position: fixed;
            bottom: 20px;
            left: 20px;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #007bff, #0056b3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
            transition: all 0.3s ease;
            z-index: 1050;
            font-size: 1.2rem;
            border: none;
            cursor: pointer;
        }

        .floating-consult-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
            color: white;
            text-decoration: none;
            background: linear-gradient(135deg, #0056b3, #004085);
        }

        .floating-consult-btn:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.3);
        }

        .floating-consult-tooltip {
            position: absolute;
            left: 70px;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            white-space: nowrap;
            font-size: 0.9rem;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .floating-consult-tooltip::after {
            content: '';
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            border: 6px solid transparent;
            border-left-color: rgba(0, 0, 0, 0.8);
        }

        .floating-consult-btn:hover .floating-consult-tooltip {
            opacity: 1;
            visibility: visible;
        }

        @media (max-width: 768px) {
            .floating-consult-btn {
                width: 50px;
                height: 50px;
                font-size: 1rem;
                bottom: 15px;
                right: 15px;
            }

            .floating-consult-tooltip {
                display: none;
            }
        }
    </style>
