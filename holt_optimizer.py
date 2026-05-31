import sys
import json
from statsmodels.tsa.holtwinters import Holt

try:
    data = json.loads(sys.argv[1])

    fit = Holt(data).fit(
        optimized=True,
        use_brute=True
    )

    result = {
        "alpha": round(float(fit.params["smoothing_level"]), 4),
        "beta": round(float(fit.params["smoothing_trend"]), 4)
    }

    print(json.dumps(result))

except Exception as e:
    print(json.dumps({"error": str(e)}))