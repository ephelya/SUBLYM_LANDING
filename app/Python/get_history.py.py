import sys
from woob.core import Woob
from woob.capabilities.bank import CapBank

def get_history(id_compte, date_debut, date_fin):
    woob = Woob()
    woob.load_backends(CapBank)

    for backend in woob.iter_backends():
        for account in backend.iter_accounts():
            if account.id == id_compte:
                for transaction in backend.iter_history(account):
                    if date_debut <= transaction.date <= date_fin:
                        print(transaction)

if __name__ == "__main__":
    id_compte = sys.argv[1]
    date_debut = sys.argv[2]
    date_fin = sys.argv[3]
    get_history(id_compte, date_debut, date_fin)
