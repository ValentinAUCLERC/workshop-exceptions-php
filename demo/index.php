<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workshop : Gestion d'Erreurs en PHP</title>
    <link rel="stylesheet" href="demo/styles.css">
</head>
<body>
    <header>
        <h1>🎓 Workshop : Gestion d'Erreurs en PHP</h1>
        <p class="subtitle">Découvrez les 3 approches de gestion d'erreurs et leurs impacts</p>
    </header>

    <main>
        <!-- Navigation globale -->
        <nav class="main-nav">
            <button class="main-nav-btn active" data-page="intro">Introduction</button>
            <button class="main-nav-btn" data-page="approach-1">Approche 1</button>
            <button class="main-nav-btn" data-page="approach-2">Approche 2</button>
            <button class="main-nav-btn" data-page="approach-3">Approche 3</button>
            <button class="main-nav-btn" data-page="advanced">Aller plus loin</button>
            <button class="main-nav-btn" data-page="conclusion">Conclusion</button>
        </nav>

        <!-- Page: Introduction -->
        <div class="page active" id="page-intro">
            <section class="intro-section">
                <h2>📖 Introduction</h2>
                <div class="intro-content">
                    <p>
                        La gestion d'erreurs est un aspect crucial du développement. Une mauvaise gestion peut
                        casser votre application, exposer des informations sensibles ou rendre le code impossible à maintenir.
                    </p>
                    <p>
                        Ce workshop vous présente <strong>3 approches progressives</strong> de gestion d'erreurs en PHP,
                        de la pire à la meilleure, avec des exemples concrets en HTML et JSON.
                    </p>
                    <div class="intro-cards">
                        <div class="intro-card bad-card">
                            <div class="card-icon">❌</div>
                            <h3>Approche 1</h3>
                            <p>echo + die()</p>
                            <span class="card-label">À ne jamais faire</span>
                        </div>
                        <div class="intro-card intermediate-card">
                            <div class="card-icon">⚠️</div>
                            <h3>Approche 2</h3>
                            <p>Erreur dans tableau</p>
                            <span class="card-label">Mieux mais problématique</span>
                        </div>
                        <div class="intro-card good-card">
                            <div class="card-icon">✅</div>
                            <h3>Approche 3</h3>
                            <p>Exceptions</p>
                            <span class="card-label">Recommandé</span>
                        </div>
                    </div>
                    <div style="text-align: center; margin-top: 3rem;">
                        <button class="demo-btn good" onclick="document.querySelector('[data-page=approach-1]').click()">
                            Commencer le workshop →
                        </button>
                    </div>
                </div>
            </section>
        </div>

        <!-- Page: Approche 1 -->
        <div class="page" id="page-approach-1">

        <section class="approach-section">
            <h2>Approche 1 : echo + die() 💀</h2>

            <div class="explanation bad">
                <h3>❌ Problèmes de cette approche :</h3>
                <ul>
                    <li>Le <code>echo()</code> envoie du texte brut qui casse le format attendu (HTML ou JSON)</li>
                    <li>Le <code>die()</code> arrête brutalement l'exécution</li>
                    <li>Le HTML reste incomplet (balises non fermées)</li>
                    <li>Le JSON devient invalide</li>
                    <li>Impossible de gérer l'erreur proprement dans le code appelant</li>
                </ul>
            </div>

            <div class="demo-section">
                <div class="demo-column">
                    <h3>📄 Exemple HTML</h3>
                    <p class="demo-description">Cliquez pour voir comment le HTML se casse</p>
                    <a href="../01-bad-approach/html-example.php" target="_blank" class="demo-btn bad">
                        Voir l'exemple HTML
                    </a>
                    <p class="tip">Inspectez le code source de la page pour voir les balises non fermées</p>
                </div>

                <div class="demo-column">
                    <h3>🔌 Exemple API JSON</h3>
                    <p class="demo-description">Cliquez pour voir le JSON cassé</p>
                    <a href="../01-bad-approach/api-example.php" target="_blank" class="demo-btn bad">
                        Voir l'API JSON
                    </a>
                    <p class="tip">Le résultat n'est même pas du JSON valide !</p>
                </div>
            </div>

            <div class="code-example">
                <h3>Code de lib.php</h3>
                <pre><code><span class="keyword">function</span> <span class="function">getUserData</span>(<span class="variable">$userId</span>) {
    <span class="variable">$users</span> <span class="operator">=</span> [<span class="comment">/* ... */</span>];

    <span class="keyword">if</span> (!<span class="function">isset</span>(<span class="variable">$users</span>[<span class="variable">$userId</span>])) {
        <span class="function">echo</span> <span class="string">"Erreur: L'utilisateur n'existe pas !"</span>;
        <span class="function">die</span>(); <span class="comment">// ⚠️ Arrêt brutal !</span>
    }

    <span class="keyword">return</span> <span class="variable">$users</span>[<span class="variable">$userId</span>];
}</code></pre>
            </div>
        </section>
        </div>

        <!-- Page: Approche 2 -->
        <div class="page" id="page-approach-2">
        <section class="approach-section">
            <h2>Approche 2 : Erreur dans tableau 🤔</h2>

            <div class="explanation intermediate">
                <h3>⚠️ Problèmes de cette approche :</h3>
                <ul>
                    <li>Le type de retour est imprévisible : parfois des données, parfois une erreur</li>
                    <li>Le code appelant DOIT vérifier <code>isset($result['error'])</code> à chaque fois</li>
                    <li>Code verbeux et répétitif (if/else partout)</li>
                    <li><strong>Risque d'oublier la vérification → <code>Undefined index "user"</code> 💥</strong></li>
                    <li>Pas de code HTTP approprié pour les APIs</li>
                </ul>
                <h3>✅ Améliorations par rapport à l'approche 1 :</h3>
                <ul>
                    <li>Le HTML/JSON reste valide et complet</li>
                    <li>Pas de <code>die()</code> qui coupe tout</li>
                </ul>
            </div>

            <div style="background: #fce4ec; padding: 1.5rem; border-radius: 12px; border-left: 5px solid #e91e63; margin-bottom: 1.5rem;">
                <h3 style="color: #880e4f; margin-bottom: 1rem;">💥 Le bug classique : "Undefined index"</h3>
                <p style="color: #880e4f; margin-bottom: 1rem;">
                    Un développeur pressé oublie de vérifier <code>isset($result['error'])</code> et accède directement à <code>$result['user']</code>.
                    Résultat : <strong>crash de l'application</strong> avec une erreur "Undefined array key"!
                </p>
                <div class="code-example" style="margin: 0;">
                    <h3>❌ Code dangereux</h3>
                    <pre><code><span class="comment">// ❌ Code dangereux (oubli de vérification)</span>
<span class="variable">$result</span> <span class="operator">=</span> <span class="function">getUserData</span>(<span class="number">999</span>);
<span class="variable">$name</span> <span class="operator">=</span> <span class="variable">$result</span>[<span class="string">'user'</span>][<span class="string">'name'</span>]; <span class="comment">// 💥 CRASH !</span>

<span style="color: #e06c75; font-weight: bold;">Fatal error: Undefined array key "user"</span></code></pre>
                </div>
            </div>

            <div class="demo-section">
                <div class="demo-column">
                    <h3>📄 Exemple HTML</h3>
                    <p class="demo-description">Le HTML est complet mais le code est lourd</p>
                    <a href="../02-intermediate/html-example.php" target="_blank" class="demo-btn intermediate">
                        Voir l'exemple HTML
                    </a>
                    <p class="tip">Remarquez les if/else répétitifs dans le code</p>
                </div>

                <div class="demo-column">
                    <h3>🔌 Exemple API JSON</h3>
                    <p class="demo-description">JSON valide mais structure incohérente</p>
                    <a href="../02-intermediate/api-example.php" target="_blank" class="demo-btn intermediate">
                        Voir l'API JSON
                    </a>
                    <p class="tip">Le code HTTP est toujours 200 OK même en cas d'erreur</p>
                </div>
            </div>

            <div class="code-example">
                <h3>Code de lib.php</h3>
                <pre><code><span class="keyword">function</span> <span class="function">getUserData</span>(<span class="variable">$userId</span>) {
    <span class="variable">$users</span> <span class="operator">=</span> [<span class="comment">/* ... */</span>];

    <span class="keyword">if</span> (!<span class="function">isset</span>(<span class="variable">$users</span>[<span class="variable">$userId</span>])) {
        <span class="keyword">return</span> [<span class="string">'error'</span> <span class="operator">=></span> <span class="string">"L'utilisateur n'existe pas"</span>];
    }

    <span class="keyword">return</span> [<span class="string">'user'</span> <span class="operator">=></span> <span class="variable">$users</span>[<span class="variable">$userId</span>]];
}

<span class="comment">// Utilisation :</span>
<span class="variable">$result</span> <span class="operator">=</span> <span class="function">getUserData</span>(<span class="number">1</span>);
<span class="keyword">if</span> (<span class="function">isset</span>(<span class="variable">$result</span>[<span class="string">'error'</span>])) {  <span class="comment">// ⚠️ À répéter partout !</span>
    <span class="comment">// Gérer l'erreur</span>
} <span class="keyword">else</span> {
    <span class="comment">// Utiliser $result['user']</span>
}</code></pre>
            </div>
        </section>
        </div>

        <!-- Page: Approche 3 -->
        <div class="page" id="page-approach-3">
        <section class="approach-section">
            <h2>Approche 3 : Exceptions 🎯</h2>

            <div class="explanation good">
                <h3>✅ Avantages de cette approche :</h3>
                <ul>
                    <li>Séparation claire entre le flux normal (try) et le flux d'erreur (catch)</li>
                    <li>Type de retour prévisible : soit des données, soit une exception</li>
                    <li>Impossible d'oublier la gestion d'erreur (exception non catchée = erreur visible)</li>
                    <li>Code propre et lisible, pas de if/else répétitifs</li>
                    <li>Codes HTTP appropriés (404, 500, etc.)</li>
                    <li>Possibilité de différencier les types d'erreurs</li>
                    <li>Gestion centralisée possible</li>
                </ul>
            </div>

            <div class="demo-section">
                <div class="demo-column">
                    <h3>📄 Exemple HTML</h3>
                    <p class="demo-description">Code propre avec try-catch élégant</p>
                    <a href="../03-exceptions/html-example.php" target="_blank" class="demo-btn good">
                        Voir l'exemple HTML
                    </a>
                    <p class="tip">Le code est lisible et l'erreur est gérée proprement</p>
                </div>

                <div class="demo-column">
                    <h3>🔌 Exemple API JSON</h3>
                    <p class="demo-description">JSON structuré avec codes HTTP corrects</p>
                    <a href="../03-exceptions/api-example.php" target="_blank" class="demo-btn good">
                        Voir l'API JSON
                    </a>
                    <p class="tip">Code HTTP 404 + JSON structuré = API professionnelle</p>
                </div>
            </div>

            <div class="code-example">
                <h3>Code de lib.php</h3>
                <pre><code><span class="keyword">class</span> <span class="function">UserNotFoundException</span> <span class="keyword">extends</span> <span class="function">Exception</span> {}

<span class="keyword">function</span> <span class="function">getUserData</span>(<span class="variable">$userId</span>) {
    <span class="variable">$users</span> <span class="operator">=</span> [<span class="comment">/* ... */</span>];

    <span class="keyword">if</span> (!<span class="function">isset</span>(<span class="variable">$users</span>[<span class="variable">$userId</span>])) {
        <span class="keyword">throw new</span> <span class="function">UserNotFoundException</span>(<span class="string">"L'utilisateur n'existe pas"</span>);
    }

    <span class="keyword">return</span> <span class="variable">$users</span>[<span class="variable">$userId</span>]; <span class="comment">// ✅ Toujours un tableau d'utilisateur</span>
}

<span class="comment">// Utilisation :</span>
<span class="keyword">try</span> {
    <span class="variable">$user</span> <span class="operator">=</span> <span class="function">getUserData</span>(<span class="number">1</span>); <span class="comment">// ✅ Type prévisible</span>
    <span class="comment">// Utiliser $user directement</span>
} <span class="keyword">catch</span> (<span class="function">UserNotFoundException</span> <span class="variable">$e</span>) {
    <span class="comment">// Gestion d'erreur centralisée et claire</span>
}</code></pre>
            </div>
        </section>
        </div>

        <!-- Page: Aller plus loin -->
        <div class="page" id="page-advanced">
        <section class="advanced-section">
            <h2>🔍 Aller plus loin avec les exceptions</h2>

            <!-- 1. Anatomie d'une exception -->
            <div class="advanced-topic">
                <h3>1️⃣ Anatomie d'une exception : qu'est-ce que j'ai dans mon catch ?</h3>

                <div class="intro-text">
                    <p>L'objet exception contient plein d'informations utiles pour déboguer et gérer les erreurs.</p>
                </div>

                <div class="code-example">
                    <h3>Méthodes disponibles</h3>
                    <pre><code><span class="keyword">try</span> {
    <span class="keyword">throw new</span> <span class="function">Exception</span>(<span class="string">"Quelque chose s'est mal passé"</span>, <span class="number">404</span>);
} <span class="keyword">catch</span> (<span class="function">Exception</span> <span class="variable">$e</span>) {
    <span class="comment">// Informations disponibles :</span>
    <span class="variable">$e</span>-><span class="function">getMessage</span>();       <span class="comment">// "Quelque chose s'est mal passé"</span>
    <span class="variable">$e</span>-><span class="function">getCode</span>();          <span class="comment">// 404</span>
    <span class="variable">$e</span>-><span class="function">getFile</span>();          <span class="comment">// "/path/to/file.php"</span>
    <span class="variable">$e</span>-><span class="function">getLine</span>();          <span class="comment">// 42</span>
    <span class="variable">$e</span>-><span class="function">getTrace</span>();         <span class="comment">// Stack trace (array)</span>
    <span class="variable">$e</span>-><span class="function">getTraceAsString</span>(); <span class="comment">// Stack trace (string)</span>
}</code></pre>
                </div>

                <div class="info-box">
                    <strong>💡 Bonnes pratiques</strong>
                    <ul>
                        <li><code>getMessage()</code> : À afficher à l'utilisateur (si safe)</li>
                        <li><code>getCode()</code> : Utile pour les codes HTTP (404, 500...) ou codes métier</li>
                        <li><code>getFile()</code> + <code>getLine()</code> + <code>getTrace()</code> : À logger, PAS à afficher (sécurité)</li>
                    </ul>
                </div>
            </div>

            <!-- 2. Catches multiples -->
            <div class="advanced-topic">
                <h3>2️⃣ Catches multiples : différencier les types d'erreurs</h3>

                <div class="intro-text">
                    <p>On peut gérer différemment chaque type d'exception.</p>
                    <p><strong>Important :</strong> ordre du plus spécifique au plus général !</p>
                </div>

                <div class="code-example">
                    <h3>Exemple avec hiérarchie</h3>
                    <pre><code><span class="keyword">class</span> <span class="function">UserNotFoundException</span> <span class="keyword">extends</span> <span class="function">Exception</span> {}
<span class="keyword">class</span> <span class="function">DatabaseException</span> <span class="keyword">extends</span> <span class="function">Exception</span> {}
<span class="keyword">class</span> <span class="function">ValidationException</span> <span class="keyword">extends</span> <span class="function">Exception</span> {}

<span class="keyword">try</span> {
    <span class="variable">$user</span> <span class="operator">=</span> <span class="function">getUserData</span>(<span class="variable">$id</span>);
    <span class="variable">$order</span> <span class="operator">=</span> <span class="function">createOrder</span>(<span class="variable">$user</span>, <span class="variable">$data</span>);

} <span class="keyword">catch</span> (<span class="function">UserNotFoundException</span> <span class="variable">$e</span>) {
    <span class="function">http_response_code</span>(<span class="number">404</span>);
    <span class="keyword">echo</span> <span class="function">json_encode</span>([<span class="string">'error'</span> <span class="operator">=></span> <span class="string">'User not found'</span>]);

} <span class="keyword">catch</span> (<span class="function">ValidationException</span> <span class="variable">$e</span>) {
    <span class="function">http_response_code</span>(<span class="number">400</span>);
    <span class="keyword">echo</span> <span class="function">json_encode</span>([<span class="string">'error'</span> <span class="operator">=></span> <span class="variable">$e</span>-><span class="function">getMessage</span>()]);

} <span class="keyword">catch</span> (<span class="function">DatabaseException</span> <span class="variable">$e</span>) {
    <span class="function">error_log</span>(<span class="variable">$e</span>-><span class="function">getMessage</span>());
    <span class="function">http_response_code</span>(<span class="number">500</span>);
    <span class="keyword">echo</span> <span class="function">json_encode</span>([<span class="string">'error'</span> <span class="operator">=></span> <span class="string">'Internal server error'</span>]);

} <span class="keyword">catch</span> (<span class="function">Throwable</span> <span class="variable">$e</span>) {
    <span class="comment">// ⚠️ VRAI catch-all : Throwable, pas Exception !</span>
    <span class="function">error_log</span>(<span class="string">"Unexpected: "</span> . <span class="variable">$e</span>-><span class="function">getMessage</span>());
    <span class="function">http_response_code</span>(<span class="number">500</span>);
    <span class="keyword">echo</span> <span class="function">json_encode</span>([<span class="string">'error'</span> <span class="operator">=></span> <span class="string">'Something went wrong'</span>]);
}</code></pre>
                </div>

                <div class="warning-box">
                    <strong>⚠️ Piège : Exception vs Throwable</strong>
                    <p>Hiérarchie PHP : <code>Throwable</code> → <code>Exception</code> / <code>Error</code></p>
                    <p><strong>Pour un vrai catch-all, utilisez <code>Throwable</code>, pas <code>Exception</code> !</strong></p>
                    <p><code>Exception</code> ne catchera pas les <code>Error</code> (TypeError, ParseError, etc.)</p>
                </div>
            </div>

            <!-- 3. Exception chaining -->
            <div class="advanced-topic">
                <h3>3️⃣ Chaînage d'exceptions : le paramètre $previous</h3>

                <div class="intro-text">
                    <p>Quand on catch une exception pour en throw une autre, on peut conserver l'exception d'origine.</p>
                    <p>Cela permet de garder toute la trace des erreurs successives.</p>
                </div>

                <div class="code-example">
                    <h3>Wrapping d'exception</h3>
                    <pre><code><span class="keyword">class</span> <span class="function">DatabaseException</span> <span class="keyword">extends</span> <span class="function">Exception</span> {}
<span class="keyword">class</span> <span class="function">UserServiceException</span> <span class="keyword">extends</span> <span class="function">Exception</span> {}

<span class="keyword">function</span> <span class="function">getUserFromDatabase</span>(<span class="variable">$id</span>) {
    <span class="keyword">try</span> {
        <span class="comment">// Connexion DB qui échoue</span>
        <span class="keyword">throw new</span> <span class="function">DatabaseException</span>(<span class="string">"Connection failed"</span>);

    } <span class="keyword">catch</span> (<span class="function">DatabaseException</span> <span class="variable">$e</span>) {
        <span class="comment">// On wrap dans une exception métier</span>
        <span class="comment">// Le 3ème paramètre = exception précédente</span>
        <span class="keyword">throw new</span> <span class="function">UserServiceException</span>(
            <span class="string">"Unable to get user"</span>,
            <span class="number">500</span>,
            <span class="variable">$e</span>  <span class="comment">// ← Exception d'origine conservée !</span>
        );
    }
}

<span class="keyword">try</span> {
    <span class="function">getUserFromDatabase</span>(<span class="number">123</span>);
} <span class="keyword">catch</span> (<span class="function">UserServiceException</span> <span class="variable">$e</span>) {
    <span class="keyword">echo</span> <span class="variable">$e</span>-><span class="function">getMessage</span>(); <span class="comment">// "Unable to get user"</span>

    <span class="comment">// Récupérer l'exception d'origine :</span>
    <span class="variable">$previous</span> <span class="operator">=</span> <span class="variable">$e</span>-><span class="function">getPrevious</span>();
    <span class="keyword">if</span> (<span class="variable">$previous</span>) {
        <span class="keyword">echo</span> <span class="variable">$previous</span>-><span class="function">getMessage</span>(); <span class="comment">// "Connection failed"</span>
    }
}</code></pre>
                </div>

                <div class="code-example">
                    <h3>Remonter toute la chaîne</h3>
                    <pre><code><span class="keyword">function</span> <span class="function">displayExceptionChain</span>(<span class="function">Throwable</span> <span class="variable">$e</span>) {
    <span class="variable">$current</span> <span class="operator">=</span> <span class="variable">$e</span>;
    <span class="variable">$level</span> <span class="operator">=</span> <span class="number">1</span>;

    <span class="keyword">while</span> (<span class="variable">$current</span> !== <span class="keyword">null</span>) {
        <span class="keyword">echo</span> <span class="string">"[$level] "</span> . <span class="function">get_class</span>(<span class="variable">$current</span>) . <span class="string">": "</span>;
        <span class="keyword">echo</span> <span class="variable">$current</span>-><span class="function">getMessage</span>() . <span class="string">"\n"</span>;

        <span class="variable">$current</span> <span class="operator">=</span> <span class="variable">$current</span>-><span class="function">getPrevious</span>();
        <span class="variable">$level</span>++;
    }
}

<span class="comment">// Résultat :</span>
<span class="comment">// [1] UserServiceException: Unable to get user</span>
<span class="comment">// [2] DatabaseException: Connection failed</span></code></pre>
                </div>

                <div class="info-box">
                    <strong>💡 Pourquoi c'est utile ?</strong>
                    <ul>
                        <li><strong>Abstraction</strong> : masquer les détails techniques (DB) derrière une erreur métier (User)</li>
                        <li><strong>Contexte</strong> : garder toute la trace pour le debugging</li>
                        <li><strong>Logs</strong> : logger l'exception complète avec getPrevious() pour tout voir</li>
                        <li><strong>Sécurité</strong> : afficher le message métier à l'user, logger les détails techniques</li>
                    </ul>
                </div>
            </div>

            <!-- 4. Finally -->
            <div class="advanced-topic">
                <h3>4️⃣ Le bloc finally : exécuté TOUJOURS</h3>

                <div class="intro-text">
                    <p>Le bloc <code>finally</code> s'exécute dans tous les cas : erreur ou succès.</p>
                    <p>Parfait pour nettoyer les ressources (fermer fichiers, connexions...).</p>
                </div>

                <div class="code-example">
                    <h3>Exemple avec ressources</h3>
                    <pre><code><span class="variable">$file</span> <span class="operator">=</span> <span class="keyword">null</span>;

<span class="keyword">try</span> {
    <span class="variable">$file</span> <span class="operator">=</span> <span class="function">fopen</span>(<span class="string">'data.txt'</span>, <span class="string">'r'</span>);
    <span class="keyword">if</span> (!<span class="variable">$file</span>) <span class="keyword">throw new</span> <span class="function">Exception</span>(<span class="string">"Cannot open file"</span>);

    <span class="variable">$content</span> <span class="operator">=</span> <span class="function">fread</span>(<span class="variable">$file</span>, <span class="function">filesize</span>(<span class="string">'data.txt'</span>));

} <span class="keyword">catch</span> (<span class="function">Exception</span> <span class="variable">$e</span>) {
    <span class="function">error_log</span>(<span class="string">"Error: "</span> . <span class="variable">$e</span>-><span class="function">getMessage</span>());

} <span class="keyword">finally</span> {
    <span class="comment">// ✅ Toujours exécuté</span>
    <span class="keyword">if</span> (<span class="variable">$file</span>) <span class="function">fclose</span>(<span class="variable">$file</span>);
}</code></pre>
                </div>

                <div class="code-example">
                    <h3>vs code après try-catch</h3>
                    <pre><code><span class="comment">// ❌ SANS finally</span>
<span class="keyword">try</span> {
    <span class="keyword">throw new</span> <span class="function">Exception</span>();
} <span class="keyword">catch</span> (<span class="function">Exception</span> <span class="variable">$e</span>) {
    <span class="keyword">return</span>;
}
<span class="function">cleanup</span>(); <span class="comment">// ❌ Jamais exécuté !</span>

<span class="comment">// ✅ AVEC finally</span>
<span class="keyword">try</span> {
    <span class="keyword">throw new</span> <span class="function">Exception</span>();
} <span class="keyword">catch</span> (<span class="function">Exception</span> <span class="variable">$e</span>) {
    <span class="keyword">return</span>;
} <span class="keyword">finally</span> {
    <span class="function">cleanup</span>(); <span class="comment">// ✅ Exécuté !</span>
}</code></pre>
                </div>

                <div class="info-box">
                    <strong>📌 Cas d'usage</strong>
                    <ul>
                        <li>Fermer fichiers / connexions DB / sockets</li>
                        <li>Libérer ressources (mémoire, locks)</li>
                        <li>Logger la fin d'opération</li>
                        <li>Cleanup / remettre état initial</li>
                    </ul>
                </div>
            </div>
        </section>
        </div>

        <!-- Page: Conclusion -->
        <div class="page" id="page-conclusion">
        <section class="conclusion-section">
            <h2>📊 Conclusion</h2>

            <!-- Tableau comparatif -->
            <div class="comparison">
            <h2>📊 Tableau Comparatif</h2>
            <table>
                <thead>
                    <tr>
                        <th>Critère</th>
                        <th>Approche 1<br>(echo + die)</th>
                        <th>Approche 2<br>(Tableau)</th>
                        <th>Approche 3<br>(Exceptions)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>HTML/JSON valide</td>
                        <td class="bad">❌ Cassé</td>
                        <td class="good">✅ Valide</td>
                        <td class="good">✅ Valide</td>
                    </tr>
                    <tr>
                        <td>Type de retour prévisible</td>
                        <td class="bad">❌ N/A (die)</td>
                        <td class="bad">❌ Mixte</td>
                        <td class="good">✅ Prévisible</td>
                    </tr>
                    <tr>
                        <td>Code propre et lisible</td>
                        <td class="intermediate">⚠️ Simple mais dangereux</td>
                        <td class="bad">❌ Verbeux</td>
                        <td class="good">✅ Élégant</td>
                    </tr>
                    <tr>
                        <td>Gestion d'erreur forcée</td>
                        <td class="bad">❌ Aucune</td>
                        <td class="bad">❌ Facultative (risque d'oubli)</td>
                        <td class="good">✅ Obligatoire</td>
                    </tr>
                    <tr>
                        <td>Codes HTTP appropriés (API)</td>
                        <td class="bad">❌ Non</td>
                        <td class="bad">❌ Toujours 200</td>
                        <td class="good">✅ Oui (404, 500, etc.)</td>
                    </tr>
                    <tr>
                        <td>Maintenabilité</td>
                        <td class="bad">❌ Très mauvaise</td>
                        <td class="intermediate">⚠️ Moyenne</td>
                        <td class="good">✅ Excellente</td>
                    </tr>
                </tbody>
            </table>
            </div>

            <!-- Message final -->
            <div class="final-message">
            <h2>🎯 Conclusion</h2>
            <div class="conclusion-box">
                <h3>À retenir :</h3>
                <ol>
                    <li><strong>N'utilisez JAMAIS echo + die()</strong> pour gérer les erreurs en production</li>
                    <li><strong>Évitez de retourner les erreurs dans des tableaux</strong>, c'est une source de bugs</li>
                    <li><strong>Utilisez les exceptions</strong> : c'est la méthode professionnelle et recommandée</li>
                    <li><strong>Les exceptions permettent</strong> :
                        <ul>
                            <li>Un code plus propre et maintenable</li>
                            <li>Une gestion d'erreur obligatoire et explicite</li>
                            <li>Des APIs correctes avec les bons codes HTTP</li>
                            <li>Une séparation claire entre le code "normal" et le code d'erreur</li>
                        </ul>
                    </li>
                </ol>
            </div>
            </div>
        </section>
        </div>
    </main>

    <footer>
        <p>Workshop créé avec ❤️ ( et le cul ) (et l'IA ) pour apprendre les bonnes pratiques PHP</p>
    </footer>

    <script>
        // Navigation entre les pages
        const navBtns = document.querySelectorAll('.main-nav-btn');
        const pages = document.querySelectorAll('.page');

        navBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const page = btn.dataset.page;

                // Update active states
                navBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                pages.forEach(p => p.classList.remove('active'));
                document.getElementById(`page-${page}`).classList.add('active');

                // Scroll to top
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });
    </script>
</body>
</html>
