<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Ultra Advanced Desktop Calculator</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;600&display=swap');

    :root {
      --clr-dark-bg: #141414;
      --clr-dark-panel: #222222;
      --clr-dark-btn: #2a2a2a;
      --clr-dark-btn-hover: #444444;
      --clr-dark-btn-active: #1c1c1c;
      --clr-dark-accent: #6d9eff;
      --clr-dark-text: #eeeeee;
      --clr-dark-error: #ff6b6b;

      --clr-light-bg: #f9fafb;
      --clr-light-panel: #e4e7eb;
      --clr-light-btn: #ffffff;
      --clr-light-btn-hover: #dee1e6;
      --clr-light-btn-active: #cfd3da;
      --clr-light-accent: #2a57ff;
      --clr-light-text: #1e1e1e;
      --clr-light-error: #d7263d;
    }

    body {
      margin: 0; padding: 0;
      font-family: 'Space Grotesk', sans-serif;
      background: var(--bg-gradient, #141414);
      color: var(--text-color, #eeeeee);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      user-select: none;
      transition: background 0.5s ease, color 0.5s ease;
    }
    body.light {
      --bg-gradient: var(--clr-light-bg);
      --panel-bg: var(--clr-light-panel);
      --btn-bg: var(--clr-light-btn);
      --btn-hover: var(--clr-light-btn-hover);
      --btn-active: var(--clr-light-btn-active);
      --accent-color: var(--clr-light-accent);
      --text-color: var(--clr-light-text);
      --error-color: var(--clr-light-error);
      background: var(--bg-gradient);
      color: var(--text-color);
    }
    body.dark {
      --bg-gradient: var(--clr-dark-bg);
      --panel-bg: var(--clr-dark-panel);
      --btn-bg: var(--clr-dark-btn);
      --btn-hover: var(--clr-dark-btn-hover);
      --btn-active: var(--clr-dark-btn-active);
      --accent-color: var(--clr-dark-accent);
      --text-color: var(--clr-dark-text);
      --error-color: var(--clr-dark-error);
      background: var(--bg-gradient);
      color: var(--text-color);
    }

    /* Calculator container */
    #calculator {
      background: var(--panel-bg, #222);
      border-radius: 24px;
      box-shadow:
        0 10px 20px rgba(0, 0, 0, 0.4),
        0 0 0 1px rgba(255, 255, 255, 0.05);
      width: 430px;
      max-width: 100vw;
      display: grid;
      grid-template-rows: auto 1fr auto;
      gap: 10px;
      padding: 20px 30px 30px 30px;
      transition: background 0.5s ease, box-shadow 0.5s ease;
    }

    /* Display area */
    #display-container {
      background: var(--btn-bg);
      border-radius: 12px;
      box-shadow:
        inset 5px 5px 12px rgba(0,0,0,0.4),
        inset -5px -5px 12px rgba(255,255,255,0.05);
      padding: 25px 30px 25px 30px;
      font-size: 2.8rem;
      font-weight: 600;
      color: var(--text-color);
      text-align: right;
      overflow-wrap: break-word;
      word-wrap: break-word;
      word-break: break-word;
      min-height: 60px;
      font-variant-numeric: tabular-nums;
      user-select: text;
      position: relative;
    }

    #display-error {
      color: var(--error-color);
      font-size: 1rem;
      margin-top: 5px;
      min-height: 22px;
      font-weight: 600;
      font-style: italic;
      transition: opacity 0.3s ease;
    }

    /* History panel */
    #history-panel {
      background: var(--btn-bg);
      border-radius: 12px;
      color: var(--text-color);
      overflow-y: auto;
      max-height: 140px;
      box-shadow:
        inset 5px 5px 12px rgba(0,0,0,0.4),
        inset -5px -5px 12px rgba(255,255,255,0.05);
      padding: 10px 20px;
      margin-top: 8px;
      display: flex;
      flex-direction: column-reverse;
      font-size: 1.05rem;
      user-select: text;
    }

    #history-panel::-webkit-scrollbar {
      width: 7px;
    }

    #history-panel::-webkit-scrollbar-thumb {
      background: var(--accent-color);
      border-radius: 10px;
    }

    /* Each history record clickable */
    .history-item {
      padding: 6px 10px;
      border-radius: 8px;
      cursor: pointer;
      user-select: none;
      margin-top: 2px;
      background: transparent;
      transition: background-color 0.15s ease;
      line-height: 1.3;
    }
    .history-item:hover,
    .history-item:focus {
      background-color: var(--accent-color);
      color: var(--btn-bg);
      outline: none;
    }

    /* Buttons container */
    #buttons-container {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: 16px;
      margin-top: 15px;
    }

    button.calc-btn {
      background: var(--btn-bg);
      border: none;
      border-radius: 14px;
      font-size: 1.5rem;
      padding: 18px 0;
      font-weight: 600;
      color: var(--text-color);
      box-shadow:
        0 5px 8px rgba(0,0,0,0.5),
        inset 0 -3px 8px rgba(255,255,255,0.05);
      cursor: pointer;
      transition:
        transform 0.15s ease,
        box-shadow 0.15s ease,
        background-color 0.3s ease,
        color 0.3s ease;
      user-select: none;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
    }
    button.calc-btn:active {
      transform: translateY(3px);
      box-shadow: 0 1px 3px rgba(0,0,0,0.9), inset 0 2px 6px rgba(255,255,255,0.15);
    }
    button.calc-btn.operator {
      background: var(--accent-color);
      color: var(--btn-bg);
      box-shadow:
        0 5px 10px rgba(15, 90, 255, 0.6),
        inset 0 -3px 8px rgba(255,255,255,0.3);
      font-weight: 700;
    }
    button.calc-btn.operator:active {
      box-shadow: 0 1px 3px rgba(15, 90, 255, 0.9), inset 0 2px 6px rgba(255,255,255,0.15);
    }
    button.calc-btn.span-two {
      grid-column: span 2;
    }
    button.calc-btn.memory {
      background: var(--btn-bg);
      color: var(--accent-color);
      font-weight: 700;
      font-size: 1.2rem;
      box-shadow: none;
    }
    button.calc-btn.memory:active {
      background: var(--btn-hover);
    }

    /* Tooltip styles */
    button.calc-btn[title]:hover::after {
      content: attr(title);
      position: absolute;
      background-color: var(--btn-bg);
      color: var(--text-color);
      padding: 6px 10px;
      font-size: 0.85rem;
      border-radius: 6px;
      top: -38px;
      white-space: nowrap;
      box-shadow: 0 2px 5px rgba(0,0,0,0.3);
      pointer-events: none;
      opacity: 0.9;
      user-select: none;
      z-index: 10;
    }

    /* Theme toggle */
    #theme-toggle {
      margin-top: 15px;
      place-self: center;
      font-size: 1.1rem;
      cursor: pointer;
      background: transparent;
      border: 2px solid var(--accent-color);
      border-radius: 24px;
      padding: 8px 22px;
      font-weight: 600;
      color: var(--accent-color);
      transition: background-color 0.3s ease, color 0.3s ease;
      user-select: none;
    }
    #theme-toggle:hover {
      background-color: var(--accent-color);
      color: var(--btn-bg);
    }
    #theme-toggle:active {
      transform: scale(0.95);
    }

    /* Responsive adjustments */
    @media (max-width: 480px) {
      #calculator {
        width: calc(100vw - 40px);
      }
    }
    
    :root {
  /* Existing colors */
  --clr-dark-bg: #141414;
  --clr-light-bg: #f9fafb;
  
  /* New themes */
  --clr-blue-bg: #1e3a8a;
  --clr-green-bg: #065f46;
  --clr-red-bg: #b91c1c;

  /* Other color variables for each theme */
  --clr-dark-text: #eeeeee;
  --clr-light-text: #1e1e1e;
  --clr-blue-text: #ffffff;
  --clr-green-text: #ffffff;
  --clr-red-text: #ffffff;
}
body.blue {
  --bg-gradient: var(--clr-blue-bg);
  --text-color: var(--clr-blue-text);
}

body.green {
  --bg-gradient: var(--clr-green-bg);
  --text-color: var(--clr-green-text);
}

body.red {
  --bg-gradient: var(--clr-red-bg);
  --text-color: var(--clr-red-text);
}

  </style>
</head>
<body class="dark" aria-label="Ultra advanced calculator">

<div id="calculator" role="application" aria-live="polite" aria-atomic="true" aria-describedby="display-error">
  <div id="display-container" tabindex="0" aria-live="polite" aria-atomic="true" aria-label="Calculator display">
    <span id="display">0</span>
    <div id="display-error" aria-live="assertive" role="alert" aria-atomic="true"></div>
  </div>
  <div id="history-panel" aria-label="Calculation history" tabindex="0" role="list"></div>
  <div id="buttons-container" role="group" aria-label="Calculator buttons">
    <button class="calc-btn memory" data-action="back" title="kembali" ><a type ="none" href="index.php#produk">home</a></button>
    <button class="calc-btn memory" data-action="MC" title="Memory Clear (MC)">MC</button>
    <button class="calc-btn memory" data-action="MR" title="Memory Recall (MR)">MR</button>
    <button class="calc-btn memory" data-action="M+" title="Memory Add (M+)">M+</button>
    <button class="calc-btn memory" data-action="M-" title="Memory Subtract (M-)">M-</button>
    <button class="calc-btn operator" data-action="clear" title="Clear All">C</button>

    <button class="calc-btn operator" data-action="open-paren" title="Open Parenthesis">(</button>
    <button class="calc-btn operator" data-action="close-paren" title="Close Parenthesis">)</button>
    <button class="calc-btn operator" data-action="backspace" title="Backspace ⌫">⌫</button>
    <button class="calc-btn operator" data-action="divide" title="Divide ÷">÷</button>
    <button class="calc-btn operator" data-action="power" title="Exponentiation ^">^</button>

    <button class="calc-btn" data-number="7" title="7">7</button>
    <button class="calc-btn" data-number="8" title="8">8</button>
    <button class="calc-btn" data-number="9" title="9">9</button>
    <button class="calc-btn operator" data-action="multiply" title="Multiply ×">×</button>
    <button class="calc-btn operator" data-action="modulus" title="Modulus %">%</button>

    <button class="calc-btn" data-number="4" title="4">4</button>
    <button class="calc-btn" data-number="5" title="5">5</button>
    <button class="calc-btn" data-number="6" title="6">6</button>
    <button class="calc-btn operator" data-action="subtract" title="Subtract −">−</button>
    <button class="calc-btn operator" data-action="factorial" title="Factorial !">!</button>

    <button class="calc-btn" data-number="1" title="1">1</button>
    <button class="calc-btn" data-number="2" title="2">2</button>
    <button class="calc-btn" data-number="3" title="3">3</button>
    <button class="calc-btn operator" data-action="add" title="Add +">+</button>
    <button class="calc-btn operator" data-action="sqrt" title="Square Root √">√</button>

    <button class="calc-btn span-two" data-number="0" title="0">0</button>
    <button class="calc-btn" data-number="." title="Decimal Point">.</button>
    <button class="calc-btn operator" data-action="equal" title="Equals =">=</button>
  </div>
  <button id="theme-toggle" aria-label="Toggle theme" aria-pressed="false">Switch Theme</button>
</div>

<script>
  (function() {
    const display = document.getElementById('display');
    const displayError = document.getElementById('display-error');
    const historyPanel = document.getElementById('history-panel');
    const buttonsContainer = document.getElementById('buttons-container');
    const themeToggle = document.getElementById('theme-toggle');

    let expression = '';
    let lastInputWasOperator = false;
    let history = [];
    let memory = 0;

    function updateDisplay(text) {
      display.textContent = text || '0';
    }

    function showError(msg) {
      displayError.textContent = msg;
      setTimeout(() => {
        if(displayError.textContent === msg) displayError.textContent = '';
      }, 3000);
    }

    function factorial(n) {
      n = Math.floor(Number(n));
      if (isNaN(n) || n < 0) return NaN;
      if (n === 0 || n === 1) return 1;
      let res = 1;
      for (let i = 2; i <= n; i++) {
        res *= i;
      }
      return res;
    }

    function parseExpression(expr) {
      expr = expr.replace(/÷/g, '/')
                 .replace(/×/g, '*')
                 .replace(/−/g, '-')
                 .replace(/\^/g, '**');

      expr = expr.replace(/√\s*(\([^()]+\)|\d+(\.\d+)?)/g, 'Math.sqrt($1)');

      while (expr.match(/(\d+(\.\d+)?|\([^()]+\))!/)) {
        expr = expr.replace(/(\d+(\.\d+)?|\([^()]+\))!/g, function(match, p1) {
          return 'factorial('+p1+')';
        });
      }

      return expr;
    }

    function evalExpression(expr) {
      const parsedExpr = parseExpression(expr);

      try {
        const func = new Function('factorial', 'Math', `return ${parsedExpr};`);
        const result = func(factorial, Math);
        if (typeof result === 'number' && !isFinite(result)) {
          throw new Error('Math Error: result is not finite');
        }
        return result;
      } catch (e) {
        return e.message || 'Error';
      }
    }

    function addToHistory(expr, result) {
      history.push({ expr, result });
      if (history.length > 20) history.shift();
      renderHistory();
    }

    function renderHistory() {
      historyPanel.innerHTML = '';
      history.forEach(({ expr, result }) => {
        const item = document.createElement('button');
        item.type = 'button';
        item.className = 'history-item';
        item.textContent = `${expr} = ${result}`;
        item.title = 'Click to reuse expression';
        item.tabIndex = 0;
        item.setAttribute('role', 'listitem');
        item.addEventListener('click', () => {
          expression = expr;
          updateDisplay(expression);
          lastInputWasOperator = false;
          historyPanel.focus();
        });
        historyPanel.appendChild(item);
      });
    }

    function appendNumberOrDot(char) {
      if (char === '.') {
        const numSegments = expression.split(/[\+\-\*\/\^\%\(\)]/);
        const lastNum = numSegments[numSegments.length - 1];
        if (lastNum.includes('.')) return;
      }
      expression += char;
      lastInputWasOperator = false;
      updateDisplay(expression);
    }

    function appendOperator(op) {
      if (expression === '' && op !== '(' && op !== '-') {
        return;
      }
      if (lastInputWasOperator) {
        if (op === '(' || op === ')') {
          expression += op;
          lastInputWasOperator = false;
          updateDisplay(expression);
        } else {
          expression = expression.slice(0, -1) + op;
          updateDisplay(expression);
        }
      } else {
        expression += op;
        lastInputWasOperator = true;
        updateDisplay(expression);
      }
    }

    function backspace() {
      if (expression.length === 0) return;
      expression = expression.slice(0, -1);
      updateDisplay(expression);
    }

    function clearAll() {
      expression = '';
      updateDisplay(expression);
      displayError.textContent = '';
      lastInputWasOperator = false;
    }

    function calculate() {
      if (expression === '') {
        showError('Expression is empty');
        return;
      }
      let trimmedExp = expression.trim();
      if (/[\+\-\*\/\^\%\(\)]$/.test(trimmedExp)) {
        showError('Expression cannot end with operator');
        return;
      }
      const result = evalExpression(expression);
      if (typeof result === 'number' && !isNaN(result)) {
        addToHistory(expression, result);
        expression = String(result);
        updateDisplay(expression);
        lastInputWasOperator = false;
      } else {
        showError('Error: ' + result);
      }
    }

    function memoryClear() {
      memory = 0;
      showError('Memory cleared');
    }
    function memoryRecall() {
      if(expression === '0' || expression === '') {
        expression = memory.toString();
      } else {
        expression += memory.toString();
      }
      updateDisplay(expression);
      lastInputWasOperator = false;
    }
    function memoryAdd() {
      const val = evalExpression(expression);
      if (typeof val === 'number' && !isNaN(val)) {
        memory += val;
        showError('Added to memory');
        clearAll();
      } else {
        showError('Cannot add invalid expression');
      }
    }
    function memorySubtract() {
      const val = evalExpression(expression);
      if (typeof val === 'number' && !isNaN(val)) {
        memory -= val;
        showError('Subtracted from memory');
        clearAll();
      } else {
        showError('Cannot subtract invalid expression');
      }
    }

    function handleKeyDown(event) {
      if (event.repeat) return;
      const key = event.key;
      if ((key >= '0' && key <= '9') || key === '.') {
        appendNumberOrDot(key);
      } else if (key === 'Enter' || key === '=') {
        event.preventDefault();
        calculate();
      } else if (key === 'Backspace') {
        event.preventDefault();
        backspace();
      } else if (key === 'Delete' || key === 'Escape') {
        event.preventDefault();
        clearAll();
      } else {
        switch (key) {
          case '+': appendOperator('+'); break;
          case '-': appendOperator('−'); break;
          case '*': appendOperator('×'); break;
          case '/': appendOperator('÷'); break;
          case '^': appendOperator('^'); break;
          case '(': appendOperator('('); break;
          case ')': appendOperator(')'); break;
          case '%': appendOperator('%'); break;
        }
      }
    }

    buttonsContainer.addEventListener('click', event => {
      if(!event.target.matches('button.calc-btn')) return;
      const btn = event.target;

      if(btn.hasAttribute('data-number')) {
        appendNumberOrDot(btn.getAttribute('data-number'));
        return;
      }
      if(btn.hasAttribute('data-action')) {
        const action = btn.getAttribute('data-action');
        switch(action) {
          case 'clear': clearAll(); break;
          case 'backspace': backspace(); break;
          case 'equal': calculate(); break;
          case 'add': appendOperator('+'); break;
          case 'subtract': appendOperator('−'); break;
          case 'multiply': appendOperator('×'); break;
          case 'divide': appendOperator('÷'); break;
          case 'modulus': appendOperator('%'); break;
          case 'power': appendOperator('^'); break;
          case 'open-paren': appendOperator('('); break;
          case 'close-paren': appendOperator(')'); break;
          case 'factorial': appendOperator('!'); break;
          case 'sqrt': appendOperator('√'); break;
          case 'MC': memoryClear(); break;
          case 'MR': memoryRecall(); break;
          case 'M+': memoryAdd(); break;
          case 'M-': memorySubtract(); break;
        }
      }
    });

    themeToggle.addEventListener('click', () => {
      if (document.body.classList.contains('dark')) {
        document.body.classList.replace('dark', 'light');
        themeToggle.textContent = 'Switch to Dark Theme';
        themeToggle.setAttribute('aria-pressed', 'true');
      } else {
        document.body.classList.replace('light', 'dark');
        themeToggle.textContent = 'Switch to Light Theme';
        themeToggle.setAttribute('aria-pressed', 'false');
      }
    });

    if (document.body.classList.contains('dark')) {
      themeToggle.textContent = 'Switch to Light Theme';
      themeToggle.setAttribute('aria-pressed', 'false');
    } else {
      themeToggle.textContent = 'Switch to Dark Theme';
      themeToggle.setAttribute('aria-pressed', 'true');
    }

    window.addEventListener('keydown', (e) => {
      if (e.ctrlKey) {
        switch (e.key.toLowerCase()) {
          case 'm':
            e.preventDefault();
            memoryRecall();
            break;
          case 'p':
            e.preventDefault();
            memoryAdd();
            break;
          case 'o':
            e.preventDefault();
            memorySubtract();
            break;
          case 'c':
            e.preventDefault();
            memoryClear();
            break;
          default:
            handleKeyDown(e);
            break;
        }
      } else {
        handleKeyDown(e);
      }
    });

    updateDisplay('0');
    renderHistory();

  })();
  const themes = ['dark', 'light', 'blue', 'green', 'red'];
let currentThemeIndex = 0;

themeToggle.addEventListener('click', () => {
  // Remove current theme class
  document.body.classList.remove(themes[currentThemeIndex]);
  
  // Update the index to the next theme
  currentThemeIndex = (currentThemeIndex + 1) % themes.length;
  
  // Add the new theme class
  document.body.classList.add(themes[currentThemeIndex]);
  
  // Update the button text
  themeToggle.textContent = `Switch to ${themes[(currentThemeIndex + 1) % themes.length]} Theme`;
});

document.body.classList.add(themes[currentThemeIndex]);
themeToggle.textContent = `Switch to ${themes[(currentThemeIndex + 1) % themes.length]} Theme`;

</script>


</body>
</html>

